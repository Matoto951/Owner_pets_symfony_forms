<?php

namespace App\Form;

use App\Entity\Pet;
use App\Entity\ToyBox;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToyBoxFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
        ;

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($options) {
            $form = $event->getForm();
            $data = $event->getData() ?? new ToyBox();

            $form
                ->add('toyBoxToys', ToyBoxToyCollectionType::class, [
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'pet' => $options["pet"],
                    'toyBox' => $data,
                ])
                ;
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ToyBox::class,
            'attr' => ['novalidate' => 'novalidate'],
            'pet' => null
        ]);
    }
}
