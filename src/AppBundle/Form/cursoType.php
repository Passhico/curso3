<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Aquí definimos los tipos "clase" que vamos a usar para definir que tipos de campos son los del formulario.
 */
use Symfony\Component\Form\Extension\Core\Type\TextType as tipo_texto;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class cursoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo', \tipo_texto::class)
            ->add('descripcion', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class)
            ->add('precio', \tipo_texto::class)
	   ->add('Guardar', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\curso'
        ));
    }
}

