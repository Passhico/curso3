<?php

namespace lacueva\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/*
 * Esto es lo importante aquí , con el campo EntitityType , podemos incluir dentro de un campo 
 * otro formulario correspondiente a una entidad.
 */
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EntriesType extends AbstractType
{

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
//        $builder->add('title')->add('content')->add('status')->add('image')->add('idUser')->add('idCategory')        ;
		$builder->add('title', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
			"label" => "Titulo",
			"attr" =>
			[
				"class" => "form-control"
			]
		]);
		$builder->add('content', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class, [
			"label" => "Contenido",
			"attr" =>
			[
				"class" => "form-control"
			]
		]);
		$builder->add('status', \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class, [
			"label" => "status",
			"choices" => ["publicado" => "publicado", "privado" => "privado"],
			"attr" => ["class" => "form-control"]
		]);
		$builder->add('idCategory', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, [
			"class" => "BlogBundle:Categories", //pero de clase de objeto.
			"label" => "Categoria",
			"attr" =>
			[
				"class" => "form-control"
			]
		]);
		
		$builder->add('tags', \Symfony\Component\Form\Extension\Core\Type\TextType::class, 		[

			"label" => "tags", 
			"attr" =>
			[
				"class" => "form-control"
			]
		]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'lacueva\BlogBundle\Entity\Entries'
		));
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBlockPrefix()
	{
		return 'lacueva_blogbundle_entries';
	}

}
