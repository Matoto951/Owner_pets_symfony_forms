<?php

namespace App\Form;

use App\Entity\Pet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Valid;

class PetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('age')
        ;

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData() ?? new Pet();

            $form
                ->add('toyBoxes', EnhancedCollectionType::class, [
                    'entry_type' => ToyBoxFormType::class,
                    'entry_options' => [
                        'pet' => $data,
                    ],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'constraints' => [
                        new Valid()
                    ],
                    'button_add' => 'Add a tox box',
                    'button_delete' => 'Delete this toy box'
                ])
                ;
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pet::class,
            'attr' => ['novalidate' => 'novalidate']
        ]);
    }
}
