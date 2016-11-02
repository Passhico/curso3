<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
//para el form que use files.
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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

		//_render
		return $this->render('BlogBundle:Entries:index.html.twig', [
					'entradas' => $this->getDoctrine()->getManager()->getRepository(\lacueva\BlogBundle\Entity\Entries::class)->findAll(),
					'categorias' => $this->getDoctrine()->getManager()->getRepository(\lacueva\BlogBundle\Entity\Categories::class)->findAll(),
		]);
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
				 * TODO: LA IMAGEN... esto hay que seguir echandole pienso...
				 * falta sabr por que no funcionan las getClientOriginal* :S
				 * y falta mostrar bien la foto en la vista.
				 * 
				 */

				/* @var $uploadedFile  \Symfony\Component\HttpFoundation\File\UploadedFile  */
				$uploadedFile = $formularioEntrada['image']->getData();

				//Guardamos el nombre y extensión orignales.
				$filename_original = 'foto'; //$uploadedFile->getClientOriginalName();
				$extension_original = 'jpg'; // $uploadedFile>getClientOriginalExtension();
				//Componemos el nuevo nombre único concatenando un time al nombre.
				$new_filename = 'images/' . $filename_original . time() . "." . $extension_original;

				//movemos Al directorio indicado con el nombre...
				$uploadedFile->move('images', $new_filename);

				//seteamos objeto imagen directamente con el nombre nuevo en la nueva entrada
				$entradaToAdd->setImage($new_filename);


				//setteamos el user con el usuario actual de la session
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

	public function deleteAction(\Symfony\Component\HttpFoundation\Request $request, int $idEntrietoDelete)
	{

		/* @var $entryToDelete  \lacueva\BlogBundle\Entity\Entries */
		$entryToDelete = $this->_miRepo()->find($idEntrietoDelete);

		/* @var $entryTagRepo \Doctrine\ORM\Repository */
		$entryTagRepo = $this->getDoctrine()->getManager()->getRepository(\lacueva\BlogBundle\Entity\Entrytag::class);

		$entryTagsAsociadasAEntradatoDelete = $entryTagRepo->findBy(["idEntry" => $idEntrietoDelete]);
		if ($entryToDelete)
		{
			try
			{
				foreach ($entryTagsAsociadasAEntradatoDelete as $et)
				{
					$this->getDoctrine()->getManager()->remove($et);
				}

				// _remove
				$this->getDoctrine()->getManager()->remove($entryToDelete);
				if ($this->getDoctrine()->getManager()->flush())
				{
					$this->_log("no se ha podido eliminar " . $entryToDelete);
				}
			} catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e)
			{
				$this->_log($e->getCode() . " Esta entrada estaría eliminada si no existiera una constraint que lo impide ");
				return $this->redirectToRoute('blog_entrada_index');
			}
		} else
			$this->_log("La entrada " . $idEntrietoDelete . " ya no existe");

		return $this->redirectToRoute('blog_entrada_index');
	}

	/**
	 * Edita una Entrada.
	 * @Route("/entrada/edit/{id}")
	 * @param Request $request
	 * 
	 * @return \Symfony\Component\HttpFoundation\Response
	 * @ParamConverter("idEntrieToEdit", class="BlogBundle:Entries")
	 * 
	 */
	public function editAction(\Symfony\Component\HttpFoundation\Request $r, $idEntrieToEdit)
	{
		/* @var $idEntrieToEdit \lacueva\BlogBundle\Entity\Entries  */
		//con el paramconverter transformamos la id en el objeto directamente. 
		
		//Bindeamos la entidad al formulario. 
		$formEditarEntrada = $this->createForm(\lacueva\BlogBundle\Form\EntriesType::class, $idEntrieToEdit);
		$formEditarEntrada->handleRequest($r);
		
		//Esto se ejecuta en orden y la siguiente únicamente lo hace si la anterior es true (ordenes de precedencia 4moreInfo.
		if ( $formEditarEntrada->isSubmitted() 
	         && $formEditarEntrada->isValid()
		&& $this->getDoctrine()->getManager()->flush()
		   )$this->_log ("no se ha podido modificar la entrada " . $idEntrieToEdit);

		//_render
		return $this->render('BlogBundle:Entries:edit.html.twig', [
					'formEditEntries' => $formEditarEntrada->createView(), 
					'entradas' => $this->_miRepo()->findAll()
		]);
	}

	/**
	 * Logea al flasbag y ademas hace un dump en la vista.
	 * 
	 * @param type  $dumpeame string object o lo que quieras
	 * 
	 */
	private function _log($dumpeame)
	{
		$this->_session->getFlashBag()->add("log", $dumpeame);
		dump($dumpeame);
	}
	
	/**
	 * Dumpea lo que se pase genearndo una Response al Kernel y para todo.
	 * 
	 * @param String|obj $param Object | string 
	 */
	function _dumpAndDie($param){
		\dump($param) && die();
	}

	/**
	 *  aka _defeaultRepo. 
	 * ---------------------------------------------------------------------------------------------
	 * Devuelve el Repo asociado a la entidad principal del controlador . 
	 * 
	 * @return \Doctrine\ORM\Repository
	 * 
	 */
	private function _miRepo()
	{
		return $this->getDoctrine()->getRepository(\lacueva\BlogBundle\Entity\Entries::class);
	}

}
