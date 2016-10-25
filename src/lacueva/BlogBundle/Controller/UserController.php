<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;

use lacueva\BlogBundle\Entity\Users;

use lacueva\BlogBundle\Form\UsersType;


class UserController extends Controller
{	
   public function loginAction(Request $r)    
  {
	   
		$autenticationUtils = $this->get("security.authentication_utils");
		$error = $autenticationUtils->getLastAuthenticationError(); 
		$lastUsername = $autenticationUtils->getLastUsername();
		
		
		//El usuario a loguear . 
		$user_to_log = new \lacueva\BlogBundle\Entity\Users();

		//Creamos el form y le pasamos el curso par que lo cargue. 
		$form = $this->createForm(\lacueva\BlogBundle\Form\UsersType::class , $user_to_log);
		$form->handleRequest($r);

		if ($form->isValid())
		{
			$status = "formulario válido" . NL;
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
						"formulario" => $form->createView()
					]
				);
   } 
}