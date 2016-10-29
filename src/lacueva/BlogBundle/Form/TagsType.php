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
		//name
		$builder->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class, 		[
		
			"label" => "TAG", 
			"attr" =>
			[
				"class" => "form_control"
			]
		]);
		//description
		$builder->add('description', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class, 		[

			"label" => "Descripción del TAG", 
			"attr" =>
			[
				"class" => "form-control col-md-6"
			]
		]);		
		//El botón 
		$builder->add('BOTON', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, 		[
			"label" => "CREAR TAG", 
			"attr" =>
			[
				"class" => "form-control btn-success"
			]
		]);
// TODO: Añadir dentro del propio tipo de formulario un botón que redirija hacia alguna otra acción . 
//		$builder->add('Listar Tags', \Symfony\Component\Form\Extension\Core\Type\ButtonType::class, [
//			"label" => "Listar las Etiquetas",
//			"attr" =>
//			[
//				"class" => "btn btn-success",
//				"href " => "/tag"
//			]
//		]);
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
