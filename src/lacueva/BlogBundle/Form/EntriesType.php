<?php

namespace lacueva\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/*
 * Esto es lo importante aquí , con el campo EntitityType , podemos incluir dentro de un campo 
 * otro formulario correspondiente a una entidad. Esto hace una consulta a la entidad referenciada y 
 * solictia un __tostring de la clase , así que este ToString tiene que ser implementado por defecto 
 * en todas las Entidades.
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


		$builder->add('idCategory', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, [
			"class" => "BlogBundle:Categories", //pero de clase de objeto.
			"label" => "Categoria",
			"attr" =>
			[
				"class" => "form-control"
			]
		]);
		$builder->add('idUser', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, [
			"class" => "BlogBundle:Users", //pero de clase de objeto.
			"label" => "Usuario",
			"attr" =>
			[
				"class" => "form-control"
			]
		]);


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
			"choices" => ["Público" => "public", "Privado" => "private"],
			"attr" => ["class" => "form-control"]
		]);

		/*
		 * TODO: Hacer que la imagen funcione bien . 
		 * 
		 */
		$builder->add('image', \Symfony\Component\Form\Extension\Core\Type\FileType::class, [
			"label" => "Imagen",
			"data_class" => null, 
			"attr" =>
			[
				"class" => "img  form-control"
			]
		]);


		/*
		 * TODO: Por que no funciona esto ? 
		 * 
		 */
		

//		$builder->add('EntryTag', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
//			"label" => "tags:",
//			"mapped" => "false", 
//			"attr" =>
//			[
//				"class" => "form-control  col-md-6l"
//			]
//		]);

		$builder->add('botonGuardar', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, [
			"label" => "guardar",
			"attr" =>
			[
				"class" => "btn btn-success form-control"
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
