<?php

namespace lacueva\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
//Clases principales 
use lacueva\BlogBundle\Entity\Categories;
use lacueva\BlogBundle\Form\CategoriesType;


class CategoryController extends Controller
{
    private $_session;

    public function __construct()
    {
        $this->_session = new \Symfony\Component\HttpFoundation\Session\Session();
    }

    public function indexAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        return $this->render('BlogBundle:Category:index.html.twig', [
                    'categorias' => $this->_miRepo()->findAll(),
        ]);
    }

    public function addAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $categoria = new \lacueva\BlogBundle\Entity\Categories();

        $formularioCategoria = $this->createForm(\lacueva\BlogBundle\Form\CategoriesType::class);
        $formularioCategoria->handleRequest($request);

        if ($formularioCategoria->isSubmitted()) {
            if (($formularioCategoria->isValid())) {
                $categoria->setName($formularioCategoria->get('name')->getData());
                $categoria->setDescription($formularioCategoria->get('description')->getData());

                // _persist
                $this->getDoctrine()->getManager()->persist($categoria);
                if ($this->getDoctrine()->getManager()->flush()) {
                    $this->_log('No se ha podido insertar la categoria');
                }
            }
        }

        return $this->render('BlogBundle:Category:add.html.twig', [
                    'formCategoryAdd' => $formularioCategoria->createView(),
                    'categorias' => $this->_miRepo()->findAll(),
        ]);
    }

    public function deleteAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $categoryToDelete = new \lacueva\BlogBundle\Entity\Categories();
        $categoryToDelete = $this->_miRepo()->find($request->get('id'));

        if ($categoryToDelete) {

            // _persist
            $this->getDoctrine()->getManager()->remove($categoryToDelete);
            if ($this->getDoctrine()->getManager()->flush()) {
                $this->_log('No se ha podido borrar la categoria.');
            }
        } else {
            $this->_log('Esta categoría ya no existe..');
        }

        return $this->redirectToRoute('blog_index_category');
    }

    public function editAction(\Symfony\Component\HttpFoundation\Request $request)
    {
        $categorytoEdit = new \lacueva\BlogBundle\Entity\Categories();

        //Si no existe la categoría a editar...
        if (!$categorytoEdit = $this->_miRepo()->find($request->get('id'))) {
            return $this->redirectToRoute('blog_edit_category_index');
        }

        $formularioCategoria = $this->createForm(\lacueva\BlogBundle\Form\CategoriesType::class, $categorytoEdit);
        $formularioCategoria->handleRequest($request);

        //Actualizamos entidad con valores del form...
        $categorytoEdit->setName($formularioCategoria->get('name')->getData());
        $categorytoEdit->setDescription($formularioCategoria->get('description')->getData());

        //Si se ha submiteado el form y es válido
        if ($formularioCategoria->isSubmitted() && $formularioCategoria->isValid()) {
            // _persist
            $this->getDoctrine()->getManager()->persist($categorytoEdit);
            if ($this->getDoctrine()->getManager()->flush()) {
                $this->_log('no se ha podido editar');
            }
        }

        return $this->render('BlogBundle:Category:edit.html.twig', [
                    'formularioCategoria' => $formularioCategoria->createView(),
                    'categorias' => $this->_miRepo()->findAll(),
        ]);
    }

    private function _log($string)
    {
        $this->_session->getFlashBag()->add('status', $string);
    }

    //PRIVS
    private function _miRepo()
    {
        return $this->getDoctrine()->getRepository('BlogBundle:Categories');
    }
}
