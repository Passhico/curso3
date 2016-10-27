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
		$usetoAdd = new \lacueva\BlogBundle\Entity\Users();

		//Creamos el form y le pasamos el curso par que lo cargue. 
		$form = $this->createForm(\lacueva\BlogBundle\Form\UsersType::class , $usetoAdd);
		$form->handleRequest($request);

		
		if ($form->isValid())
		{
			$status = $form->getName() . " Tiene dattos válidos. "; 
			
			$usetoAdd->setName($form->get("name")->getData());
			$usetoAdd->setSurname($form->get("surname")->getData());
			$usetoAdd->setEmail($form->get("email")->getData());
			$usetoAdd->setPassword($form->get("password")->getData());
			
			$status = [$usetoAdd, "algo", "mierda" ,$this] ;
			
			$this->getDoctrine()->getManager()->persist($usetoAdd);
			$this->getDoctrine()->getManager()->flush();
			
			
			
			
			
//			$data = [
//				"titulo" => $form->get("titulo")->getData(),
//				"descripcion" => $form->get("descripcion")->getData(),
//				"precio" => $form->get("precio")->getData()
//			];
		} else
		{
			$status = $form->getName() . " No tiene datos válidos o faltan. ";
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