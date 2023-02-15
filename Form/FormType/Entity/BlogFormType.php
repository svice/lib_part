<?php
namespace App\Form\FormType\Entity;

use App\Enum\BlogTypeEnum;
use App\Form\AppAwareFormType;
use App\Form\Type\BookListSelectType;
use App\Form\Type\ListSelectType;
use App\Form\Type\VideoSelectType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class BlogFormType extends AppAwareFormType
{
	protected function doBuildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('title', TextType::class, [
				'label' => 'Название',
			])

			->add('type', ChoiceType::class, [
				'choices' => array_flip(BlogTypeEnum::getTranslates()),
				'placeholder' => 'Нет',
				'label' => 'Тип',
			])

			->add('uri', TextType::class, [
				'label'    => 'Путь',
				'required' => false,
			])

			->add('body', TextareaType::class, [
				'label'    => 'Тело статьи',
				'required' => false,
			])

			->add('active', CheckboxType::class, [
				'label'    => 'Выводить в разделе «Статьи»',
				'required' => false,
			])

			->add('list', BookListSelectType::class, [
				'label' => 'Полка',
				'placeholder' => 'Нет',
				'required' => false,
				'attr' => [
					'class' => 'select2'
				]
			])

			->add('videos', CollectionType::class, [
				'label'         => 'Видео',
				'entry_type'    => VideoSelectType::class,
				'allow_add'     => true,
				'allow_delete'  => true,
				'prototype'     => true,
			])
		;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return 'blog_form';
	}
}
