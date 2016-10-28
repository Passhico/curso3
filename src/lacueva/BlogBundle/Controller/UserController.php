<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use lacueva\BlogBundle\Entity\Users;
use lacueva\BlogBundle\Form\UsersType;

class UserController extends Controller
{

	private $_session;

	public function __construct()
	{
		$this->_session = new \Symfony\Component\HttpFoundation\Session\Session();
	}

	public function loginAction(Request $request)
	{

		$autenticationUtils = $this->get("security.authentication_utils");
		$error = $autenticationUtils->getLastAuthenticationError();
		$lastUsername = $autenticationUtils->getLastUsername();

		//El usuario a loguear . 
		$userToAdd = new \lacueva\BlogBundle\Entity\Users();

		//Creamos el form y le pasamos el curso par que lo cargue. 
		$form = $this->createForm(\lacueva\BlogBundle\Form\UsersType::class, $userToAdd);
		$form->handleRequest($request);

		$status = "El formulario con nombre: " . $form->getName();


		if ($form->isSubmitted() & $form->isValid())
		{
			$userToAdd->setName($form->get("name")->getData());
			$userToAdd->setSurname($form->get("surname")->getData());
			$userToAdd->setEmail($form->get("email")->getData());
			$userToAdd->setRole("ROLE_USER");

//			_encrypt

			$pass_to_encode = $form->get("password")->getData();

			//para netbeans..
//			$factory = new \Symfony\Component\Security\Core\Encoder\EncoderFactory();

			$factory = $this->get("security.encoder_factory");
			$encoder = $factory->getEncoder($userToAdd);
			$password_codificado = $encoder->encodePassword($pass_to_encode, $userToAdd->getSalt());


			$userToAdd->setPassword($password_codificado);

			//a buen tenedor labrastan
			if (!$this->_esUsuarioRegistrado($userToAdd))
			{
				//persist
				$this->getDoctrine()->getManager()->persist($userToAdd);
				$this->getDoctrine()->getManager()->flush();
				
				$status .= " Tiene datos válidos " . NL .
						" insertando user con password codificado" . $password_codificado;
			}
			else
				$status  .= "El usuario que intenta registrar ya EXISTE!!";
			
			
		} else
		{

			$status .= $form->getName() . " No tiene datos válidos o faltan. ";
		}
		//Concatenamos al status el id de la flash session , por que sí . 
		$status .= "Por cierto, estamos en la sesión con id : " . $this->_session->getId();


		$this->_session->getFlashBag()->add("status", $status);

		return $this->render("login.html.twig", ["error" => $error,
					"last_username" => $lastUsername,
					"users" => $this->getDoctrine()->getRepository("BlogBundle:Users")->findAll(),
					"formulario" => $form->createView(),
					"estado" => $status
						]
		);
	}

	private function _esUsuarioRegistrado(\lacueva\BlogBundle\Entity\Users $usuarioAverificar)
	{
		//eL return nos lo podemos ahorrar si el 0 es false... pero es mas legible...
		return(
			$this->getDoctrine()
				->getManager()
				->getRepository("BlogBundle:Users")
				->findOneBy(['email' => $usuarioAverificar->getEmail()])
		)?true:false;
		
	}
	
}
