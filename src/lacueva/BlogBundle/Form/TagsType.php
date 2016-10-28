<?php

namespace lacueva\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TagsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
	
		$builder->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class, 		[
			"required" => "required", 
			"label" => "TAG", 
			"attr" =>
			[
				"class" => "css_stylel"
			]
		]);
		
		$builder->add('description', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class, 		[
			"required" => "required", 
			"label" => "Descripción del TAG", 
			"attr" =>
			[
				"class" => "css_stylel"
			]
		]);
		
		//El botón 
		$builder->add('BOTON', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, 		[
			"label" => "CREAR TAG", 
			"required" => "required", 
			"attr" =>
			[
				"class" => "css_stylel"
			]
		]);
		
		
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'lacueva\BlogBundle\Entity\Tags'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lacueva_blogbundle_tags';
    }


}
