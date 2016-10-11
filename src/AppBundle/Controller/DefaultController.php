<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Curso;
use AppBundle\Entity\Producto;
use AppBundle\Entity\Usuario;


define("NL", "<br>");

class DefaultController extends Controller
{
 
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    public function addAction(Request $r) {
       
        
        for ($i=0;$i<100;$i++)
        {
            $c  = new Curso();
            $c->setDescripcion("Este es un curso de mierda , pero bueno ...." . $i);
            $c->setTitulo("Este es el curso de la mierda " . $i); 
            $c->setPrecio(800.0 + $i);
            
            

            $em = $this->getDoctrine()->getManager();
            $em->persist($c);
            $f  = $em->flush();

            Dump($f);
            Dump($c);
            
            $p = new Producto();
            
        }

       
        die();
    }
   
    public function readAction(Request $param) 
    {
        $doctrine  = $this->getDoctrine();
        $em = $doctrine->getManager(); 
        
        $cursosRepo  = $em->getRepository("AppBundle:curso");
        
        $cursos = $cursosRepo->findAll(); 
        
        foreach ($cursos as $curso)
        {
            echo $curso->getTitulo()."<br>";
            echo $curso->getDescripcion()."<br>";
            echo $curso->getPrecio()."<br>";
        }
        die();
        
    }
        
    public function updateAction($id, $titulo, $descripcion , $precio)
    {
        
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager(); 
        $cursoRepo = $em->getRepository("AppBundle:curso");
        
        $curso  = $cursoRepo->find($id); //cargamos los datos del id 
        
        $curso->setTitulo($titulo);
        $curso->setDescripcion($descripcion);
        $curso->setPrecio($precio);
        
        $em->persist($curso); 
        
        if ( $em->flush() == null )
        {
            echo "Actualizado registro " . $id . "<br>";
            Dump($curso);
        }
        else //eRROR
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
        
        if ( $this->getDoctrine()->getManager()->flush() )
            echo "error deleteando ". $id_to_delete . "<br>";
        else
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
}
