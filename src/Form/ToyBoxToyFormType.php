<?php

namespace App\Form;

use App\Entity\ToyBoxToy;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToyBoxToyFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', null, [
                'required' => false,
            ])
            ->add('price', null, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ToyBoxToy::class,
            'attr' => ['novalidate' => 'novalidate']
        ]);
    }

}