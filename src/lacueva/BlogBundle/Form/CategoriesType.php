<?php

namespace lacueva\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $builder->add('name')->add('description')        ;
		
		$builder->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class, 		[
			"required" => "required", 
			"attr" =>

			[
				"class" => "col-md-6"
			]
		]);
		$builder->add('description', \Symfony\Component\Form\Extension\Core\Type\TextType::class, 		[
			"required" => "required", 
			"attr" =>

			[
				"class" => "col-md-6"
			]
		]);
		$builder->add('botonSubmit', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, 		[
			"label" => "GUARDAR", 
			"attr" =>
			[
				"class" => "btn btn-warning"
			]
		]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'lacueva\BlogBundle\Entity\Categories'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lacueva_blogbundle_categories';
    }


}
