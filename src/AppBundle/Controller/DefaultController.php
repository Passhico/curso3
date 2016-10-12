<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Curso;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Usuario;
use Doctrine\ORM\QueryBuilder as qb;

define("NL", "<br>");

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
	// replace this example code with whatever you need
	return $this->render('default/index.html.twig', [
		    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
	]);
    }

    public function addAction(Request $r)
    {


	for ($i = 0; $i < 100; $i++)
	{
	    $c = new Curso();
	    $c->setDescripcion("Este es un curso de mierda , pero bueno ...." . $i);
	    $c->setTitulo("Este es el curso de la mierda " . $i);
	    $c->setPrecio(800.0 + $i);



	    $em = $this->getDoctrine()->getManager();
	    $em->persist($c);
	    $f = $em->flush();

	    Dump($f);
	    Dump($c);

	    $p = new Producto();
	}


	die();
    }

    public function readAction(Request $param)
    {
	$doctrine = $this->getDoctrine();
	$em = $doctrine->getManager();

	$cursosRepo = $em->getRepository("AppBundle:curso");

	$cursos = $cursosRepo->findAll();

	foreach ($cursos as $curso)
	{
	    echo $curso->getTitulo() . "<br>";
	    echo $curso->getDescripcion() . "<br>";
	    echo $curso->getPrecio() . "<br>";
	}
	die();
    }

    public function updateAction($id, $titulo, $descripcion, $precio)
    {

	$doctrine = $this->getDoctrine();
	$em = $doctrine->getManager();
	$cursoRepo = $em->getRepository("AppBundle:curso");

	$curso = $cursoRepo->find($id); //cargamos los datos del id 

	$curso->setTitulo($titulo);
	$curso->setDescripcion($descripcion);
	$curso->setPrecio($precio);

	$em->persist($curso);

	if ($em->flush() == null)
	{
	    echo "Actualizado registro " . $id . "<br>";
	    Dump($curso);
	} else //eRROR
	{
	    echo "ERROR AL FLUSHEAR ...";
	}

	die();
    }

    public function deleteAction($id_to_delete)
    {
	$this->getDoctrine()->getManager()->remove(
		$this->getDoctrine()->getManager()->getRepository("AppBundle:curso")->find($id_to_delete)
	);

	if ($this->getDoctrine()->getManager()->flush())//si null ok  
	    echo "error deleteando " . $id_to_delete . "<br>";
	else //Error
	    echo "ELIMINADO REGISTRO " . $id_to_delete . "<br>";

	die();
    }

    public function nativeSqlAction()
    {
	$ddbb = $this->getDoctrine()->getManager()->getConnection();
	$stmt = $ddbb->prepare("select * from cursos;");
	$stmt->execute(array());

	$cursos = $stmt->fetchAll();


	foreach ($cursos as $c)//printa
	{
	    echo "TITULO:" . $c['titulo'] . NL;
	    echo "PRECIO:" . $c['precio'] . NL;
	    echo NL;
	}
	die();
    }

    public function queryBuilderAction()
    {	
		/*
	//Preparamos el repo
	$repo = $this->getDoctrine()->getManager()->getRepository("AppBundle:curso");
	
	//Para preparar querys se usa el builder . 
	$query = $repo->createQueryBuilder("c");
	$query->where("c.precio > :precio");
	$query->setParameter("precio", "79");
	$query = $query->getQuery();

	$cursos = $query->getResult();
	*/
        $cursos = \AppBundle\Repository\cursoRepository::getCursos();

	foreach ($cursos as $c)//printa
	{
	    echo $c->getTitulo() . NL;
	    echo $c->getPrecio() . NL;
	    echo NL;
	}
	


	
	die();
	
	
	
    }

}
