<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;

use lacueva\BlogBundle\Entity\Users;

use lacueva\BlogBundle\Form\UsersType;


class UserController extends Controller
{	
   public function loginAction(Request $request)    
  {
	   
		$autenticationUtils = $this->get("security.authentication_utils");
		$error = $autenticationUtils->getLastAuthenticationError(); 
		$lastUsername = $autenticationUtils->getLastUsername();
		
		
		//El usuario a loguear . 
		$user_to_log = new \lacueva\BlogBundle\Entity\Users();

		//Creamos el form y le pasamos el curso par que lo cargue. 
		$form = $this->createForm(\lacueva\BlogBundle\Form\UsersType::class , $user_to_log);
		$form->handleRequest($request);

		
		if ($form->isValid())
		{
			$status = "formulario válido";
//			$data = [
//				"titulo" => $form->get("titulo")->getData(),
//				"descripcion" => $form->get("descripcion")->getData(),
//				"precio" => $form->get("precio")->getData()
//			];
		} else
		{
			$status = "NO SE HA REGISTRADO CORRECTAMENTE";
			$data = [];
		}

	
		return $this->render("login.html.twig", 
					[	"error" => $error , 
						"last_username" => $lastUsername, 
						"users" => $this->getDoctrine()->getRepository('BlogBundle:Users')->findAll(), 
						"formulario" => $form->createView(), 
						"estado" => $status
					]
				);
   } 
}