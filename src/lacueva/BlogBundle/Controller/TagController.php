<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use lacueva\BlogBundle\Entity\Users;
use lacueva\BlogBundle\Form\UsersType;

//Clases principales 
use lacueva\BlogBundle\Entity\Tags; 
use lacueva\BlogBundle\Form\TagsType; 

class TagController extends Controller
{

	private $_session;

	public function __construct()
	{
		$this->_session = new \Symfony\Component\HttpFoundation\Session\Session();
	}
	
	function AddAction(\Symfony\Component\HttpFoundation\Request $request)
	{
		$this->render("addTag.html.twig");
		
		
	}

}
