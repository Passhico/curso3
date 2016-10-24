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


class UserController extends Controller
{	
   public function loginAction(Request $r)    
  {
	   
		$autenticationUtils = $this->get("security.authentication_utils");
		$error = $autenticationUtils->getLastAuthenticationError(); 
		$lastUsername = $autenticationUtils->getLastUsername();
		
		
		return $this->render("login.html.twig", 
					[	"error" => $error , 
						"last_username" => $lastUsername, 
						"users" => $this->getDoctrine()->getRepository('BlogBundle:Users')->findAll()
					]
				);
   } 
}