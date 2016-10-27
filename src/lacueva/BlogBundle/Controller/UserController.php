<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

use lacueva\BlogBundle\Entity\Users;

use lacueva\BlogBundle\Form\UsersType;


class UserController extends Controller
{	
	
	private  $_session;
	
	public function __construct()
	{
		$this->_session = new sessi
		
	}

	
	
	public function loginAction(Request $request)    
  {

	  $autenticationUtils = $this->get("security.authentication_utils");
		$error = $autenticationUtils->getLastAuthenticationError(); 
		$lastUsername = $autenticationUtils->getLastUsername();
				
		//El usuario a loguear . 
		$userToAdd = new \lacueva\BlogBundle\Entity\Users();

		//Creamos el form y le pasamos el curso par que lo cargue. 
		$form = $this->createForm(\lacueva\BlogBundle\Form\UsersType::class , $userToAdd);
		$form->handleRequest($request);

		if ($form->isValid())
		{
			$userToAdd->setName($form->get("name")->getData());
			$userToAdd->setSurname($form->get("surname")->getData());
			$userToAdd->setEmail($form->get("email")->getData());
			$userToAdd->setPassword($form->get("password")->getData());
				
			$this->getDoctrine()->getManager()->persist($userToAdd);
			$this->getDoctrine()->getManager()->flush();
			
			$status = [ $form->getName() ,  " Tiene datos válidos", $userToAdd];
			
		} else
		{
		
			$status = $form->getName() . " No tiene datos válidos o faltan. ";
			
		}
		
		$s = new \Symfony\Component\HttpFoundation\Session();
		\Symfony\Component\HttpFoundation\Session
		$s = $this->_session;
		
		$s = new \Symfony\Component\HttpFoundation\Session\Session();
	
	
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