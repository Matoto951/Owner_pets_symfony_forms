<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EnhancedCollectionType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        parent::buildView($view, $form, $options);

        $data = $form->getData();


        $view->vars['button_add'] = $options['button_add'];
        $view->vars['button_add_attr'] = $options['button_add_attr'];
        $view->vars['button_add_html'] = $options['button_add_html'];
        $view->vars['button_add_translation_parameters'] = $options['button_add_translation_parameters'];
        $view->vars['button_delete'] = $options['button_delete'];
        $view->vars['button_delete_attr'] = $options['button_delete_attr'];
        $view->vars['button_delete_html'] = $options['button_delete_html'];
        $view->vars['button_delete_translation_parameters'] = $options['button_delete_translation_parameters'];
        $view->vars['entry_container_attr'] = $options['entry_container_attr'];

        // stimulus controller name and values
        $view->vars['controller_values']['allow-add'] = $options['allow_add'];
        $view->vars['controller_values']['allow-delete'] = $options['allow_delete'];
        $view->vars['controller_values']['button-add-position'] = $options['button_add_position'];
        $view->vars['controller_values']['button-delete-position'] = $options['button_delete_position'];
        $view->vars['controller_values']['prototype_name'] = $options['prototype_name'];
        $view->vars['controller_values']['start-index'] = is_countable($data) ? \count($data) : 0;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefined([
            'button_add',
            'button_add_attr',
            'button_add_html',
            'button_add_translation_parameters',
            'button_add_position',
            'button_delete',
            'button_delete_attr',
            'button_delete_html',
            'button_delete_translation_parameters',
            'button_delete_position',
            'entry_container_attr',
        ]);

        $resolver->setAllowedTypes('button_add', ['null', 'string']);
        $resolver->setAllowedTypes('button_add_attr', ['array']);
        $resolver->setAllowedTypes('button_add_html', ['bool']);
        $resolver->setAllowedTypes('button_add_translation_parameters', ['array']);
        $resolver->setAllowedTypes('button_add_position', ['string']);
        $resolver->setAllowedTypes('button_delete', ['null', 'string']);
        $resolver->setAllowedTypes('button_delete_attr', ['array']);
        $resolver->setAllowedTypes('button_delete_html', ['bool']);
        $resolver->setAllowedTypes('button_delete_translation_parameters', ['array']);
        $resolver->setAllowedTypes('button_delete_position', ['string']);
        $resolver->setAllowedTypes('entry_container_attr', ['array']);

        $resolver->setAllowedValues('button_add_position', ['beforebegin', 'afterbegin', 'beforeend', 'afterend']);
        $resolver->setAllowedValues('button_delete_position', ['afterbegin', 'beforeend']);

        $resolver->setDefaults([
            'button_add' => null,
            'button_add_attr' => [],
            'button_add_html' => false,
            'button_add_translation_parameters' => [],
            'button_add_position' => 'afterend',
            'button_delete' => null,
            'button_delete_attr' => [],
            'button_delete_html' => false,
            'button_delete_translation_parameters' => [],
            'button_delete_position' => 'beforeend',
            'entry_container_attr' => [],
        ]);
    }

    public function getParent(): string
    {
        return CollectionType::class;
    }
}