<?php

namespace lacueva\BlogBundle\Controller;

//para el form que use files.

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use lacueva\BlogBundle\Entity\Categories;
use lacueva\BlogBundle\Entity\Entries;
use lacueva\BlogBundle\Entity\EntriesRepo;
use lacueva\BlogBundle\Entity\Entrytag;
use lacueva\BlogBundle\Form\EntriesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class EntriesController extends Controller
{
    private $_session;

    public function __construct()
    {
        $this->_session = new Session();
    }

    /**
     * Muestra la página que se le pasa como parámetro en la Vista.
     *
     * @param Request $request
     * @param int     $pagina
     *
     * @return Response
     */
    public function indexAction(Request $request, int $pagina)
    {

        /* @var $miRepo EntriesRepo */
        $miRepo = $this->_miRepo();

//Entradas paginadas
        $entradas = $this->_miRepo()->getPaginateEntries($pagesize = 10, $pagina);

        $totalEntradas = count($entradas);
        $pageCount = ceil($totalEntradas / $pagesize);

        //_render
        return $this->render('BlogBundle:Entries:index.html.twig', [
                    'entradas' => $entradas,
                    'totalEntradas' => $totalEntradas,
                    'pageCount' => $pageCount,
                    'paginaActual' => $pagina,
                    'categorias' => $this->getDoctrine()->getManager()->getRepository(Categories::class)->findAll(),
        ]);
    }

    /*
     * TODO: HACER UNA VISTA PARA UNA SOLA ENTRADA.
     */

    public function viewOneAction(Request $request, Entries $idEntrie)
    {
        return new Response(dump($this).
                'Esto es una Stub de Action, posiblemente quieras usar en esta linea :
	  return $this->render($view)');
    }

    public function addAction(Request $request)
    {
        
		
		$entradaToAdd = new Entries();

        $formularioEntrada = $this->createForm(EntriesType::class, $entradaToAdd);

        $formularioEntrada->handleRequest($request);

        if ($formularioEntrada->isSubmitted()) {
            if (($formularioEntrada->isValid())) {
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

                /* @var $uploadedFile  UploadedFile  */
                $uploadedFile = $formularioEntrada['image']->getData();

                //Guardamos el nombre y extensión orignales.
                $filename_original = 'foto'; //$uploadedFile->getClientOriginalName();
                $extension_original = 'jpg'; // $uploadedFile>getClientOriginalExtension();
                //Componemos el nuevo nombre único concatenando un time al nombre.
                $new_filename = 'images/'.$filename_original.time().'.'.$extension_original;

                //movemos Al directorio indicado con el nombre...
                $uploadedFile->move('images', $new_filename);

                //seteamos objeto imagen directamente con el nombre nuevo en la nueva entrada
                $entradaToAdd->setImage($new_filename);

                //setteamos el user con el usuario actual de la session
                //_getuser
                $entradaToAdd->setIdUser($this->getUser());

                //persist
                $this->getDoctrine()->getManager()->persist($entradaToAdd);
                if ($this->getDoctrine()->getManager()->flush()) {
                    $this->_log('No se ha podido insertar la Entrada ');
                }
            }
        }

		
	


		
        return $this->render('BlogBundle:Entries:add.html.twig', [
                    'formAddEntries' => $formularioEntrada->createView(),
                    'entradas' => $this->_miRepo()->findAll()
					
			
        ]);
    }
	

    public function deleteAction(Request $request, int $idEntrietoDelete)
    {

        /* @var $entryToDelete  Entries */
        $entryToDelete = $this->_miRepo()->find($idEntrietoDelete);

        /* @var $entryTagRepo \Doctrine\ORM\Repository */
        $entryTagRepo = $this->getDoctrine()->getManager()->getRepository(Entrytag::class);

        $entryTagsAsociadasAEntradatoDelete = $entryTagRepo->findBy(['idEntry' => $idEntrietoDelete]);
        if ($entryToDelete) {
            try {
                foreach ($entryTagsAsociadasAEntradatoDelete as $et) {
                    $this->getDoctrine()->getManager()->remove($et);
                }

                // _remove
                $this->getDoctrine()->getManager()->remove($entryToDelete);
                if ($this->getDoctrine()->getManager()->flush()) {
                    $this->_log('no se ha podido eliminar '.$entryToDelete);
                }
            } catch (ForeignKeyConstraintViolationException $e) {
                $this->_log($e->getCode().' Esta entrada estaría eliminada si no existiera una constraint que lo impide ');

                return $this->redirectToRoute('blog_entrada_index', ['pagina' => 1]);
            }
        } else {
            $this->_log('La entrada '.$idEntrietoDelete.' ya no existe');
        }

        return $this->redirectToRoute('blog_entrada_index', ['pagina' => 1]);
    }

    /**
     * Edita una Entrada.
     *
     * @Route("/entrada/edit/{id}")
     *
     * @param Request $request
     *
     * @return Response
     * @ParamConverter("idEntrieToEdit", class="BlogBundle:Entries")
     */
    public function editAction(Request $r, $idEntrieToEdit)
    {
        /* @var $idEntrieToEdit Entries  */
        //con el paramconverter transformamos la id en el objeto directamente.
        //Bindeamos la entidad al formulario.
        $formEditarEntrada = $this->createForm(EntriesType::class, $idEntrieToEdit);
        $formEditarEntrada->handleRequest($r);

        //Esto se ejecuta en orden y la siguiente únicamente lo hace si la anterior es true (ordenes de precedencia 4moreInfo.
        if ($formEditarEntrada->isSubmitted() && $formEditarEntrada->isValid() && $this->getDoctrine()->getManager()->flush()
        ) {
            $this->_log('no se ha podido modificar la entrada '.$idEntrieToEdit);
        }

        //_render
        return $this->render('BlogBundle:Entries:edit.html.twig', [
                    'formEditEntries' => $formEditarEntrada->createView(),
                    'entradas' => $this->_miRepo()->findAll(),
        ]);
    }

    /**
     * Logea al flasbag y ademas hace un dump en la vista.
     * @param type $dumpeame string object o lo que quieras
     */
    private function _log($dumpeame)
    {
        $this->_session->getFlashBag()->add('log', $dumpeame);
        dump($dumpeame);
    }

    /**
     * Dumpea lo que se pase genearndo una Response al Kernel y para todo.
     *
     * @param string|obj $param Object | string
     */
    public function _dumpAndDie($param)
    {
        dump($param) && die();
    }

    /**
     *  aka _defeaultRepo.
     * ---------------------------------------------------------------------------------------------
     * Devuelve el Repo asociado a la entidad principal del controlador .
     *
     * @return EntriesRepo
     */
    private function _miRepo()
    {
        /* @var $this EntriesController */
        return $this->getDoctrine()->getRepository(Entries::class);
    }
}
