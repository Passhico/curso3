<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

class EntriesController extends Controller
{

	private $_session;

	public function __construct()
	{
		$this->_session = new \Symfony\Component\HttpFoundation\Session\Session();
	}

	//_action
	public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
	{

		;

		return new \Symfony\Component\HttpFoundation\Response(dump($this) .
				"Esto es una Stub de indexAction, posiblemente quieras usar en esta linea :
		  return \$this->render(\$view)");
	}

	public function addAction(\Symfony\Component\HttpFoundation\Request $request)
	{

		$entradaToAdd = new \lacueva\BlogBundle\Entity\Entries();

		$formularioEntrada = $this->createForm(\lacueva\BlogBundle\Form\EntriesType::class, $entradaToAdd);
		$formularioEntrada->handleRequest($request);


		if ($formularioEntrada->isSubmitted())
		{
			if (( $formularioEntrada->isValid()))
			{
				/* EXPLICACIÓN IMPORTANTE: 
				 *  Aquí no tenemos que hacer nada más , ni geters ni seters 
				 * Porque directamente , al crear el formulario hemos bindeado
				 * la entidad , y esto hace que cuando se hace el flush() se sincroniza automáticamente
				 * Por supuesto , sí que tendremos que modificar algunos valores tal cual 
				 * se quedan cargados en la entidad si no es el valor que queremos . 
				 * 
				 * Un ejemplo es la img , en la que se crea el nombre temporal y es el que 
				 * quedaría en la base de datos si hacemos el flush antes de copiar el archivo
				 * y cambiarla el nombre, otra cosa que hay que dejar cargada , sería el id del 
				 * usuario , el cual no debe poder elegirse desde el formulario , sino que 
				 * ha de hacerse de forma automática. 
				 * 
				 */
				
				
				
				/*
				 * TODO: LA IMAGEN
				 */
				$imageUploaded = new \Symfony\Component\HttpFoundation\File\UploadedFile(
						$formularioEntrada['image']->getData(), //ruta
						'foto_entrada_' . $entradaToAdd->getIdUser() . $entradaToAdd->getTitle() //nombre
				);
				$imageUploaded->move("images", 'foto_entrada_' . $entradaToAdd->getIdUser() . $entradaToAdd->getTitle());
				$entradaToAdd->setImage($imageUploaded);
				
				/************************************************/
				
				//_getuser
				$entradaToAdd->setIdUser($this->getUser());

				//persist
				$this->getDoctrine()->getManager()->persist($entradaToAdd);
				if ($this->getDoctrine()->getManager()->flush())
					$this->_log("No se ha podido insertar la Entrada ");
			}
		}

		return $this->render('BlogBundle:Entries:add.html.twig', [
					'formAddEntries' => $formularioEntrada->createView(),
					'entradas' => $this->_miRepo()->findAll()
		]);
	}

	//PRIVS
	private function _log($dumpeame)
	{


		$this->_session->getFlashBag()->add("log", $string);
		dump($m);
	}

	private function _miRepo()
	{
		return $this->getDoctrine()->getRepository("BlogBundle:Entries");
	}

}
