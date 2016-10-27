<?php

namespace lacueva\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class UsersType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
	    //        $builder->add('role')->add('name')->add('surname')->add('email')->add('password')->add('image')        ;

        $builder->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class,
		[
		    "required" => "required", 
		    "label" => "¿Como te llamas?", 
		    "attr" => 
		    [
			"class" => "form-name form-control" //AQUÍ LOS CSS
		    ]
		]);
        $builder->add('surname', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
			"required" => "required",
			"label" => "apellido",
			"attr" =>
			[
				"class" => "form-surname form-control"
			]
		]);
		$builder->add('email', \Symfony\Component\Form\Extension\Core\Type\EmailType::class,
		[
		    "required" => "required", 
		    "attr" => 
		    [
			"class" => "form-email form-control"
		    ]
		]);
        $builder->add('password', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class,
		[
		    "required" => "required", 
			"label" => "teclea en voz baja tu contraseña :)", 
		    "attr" => 
		    [
			"class" => "form-password form-control"
		    ]
		]);
		
		$builder->add('Guardar', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, [
			"attr" =>
			[
				"class" => "form-submit btn btn-success"
			], 
			"label" => "Darse de alta en el Blog"
		]);

	
	}

    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'lacueva\BlogBundle\Entity\Users'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lacueva_blogbundle_users';
    }


}
