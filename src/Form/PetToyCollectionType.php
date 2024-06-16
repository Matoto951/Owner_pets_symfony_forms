<?php

namespace App\Form;

use App\Entity\PetToy;
use App\Entity\Toy;
use App\Repository\ToyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PetToyCollectionType extends AbstractType
{
    private $toys;

    public function __construct(ToyRepository $toyRepository)
    {
        $this->toys = $toyRepository->findAll();
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($options){
            $form = $event->getForm();
            $data = $event->getData();


            $pet = $options['pet'];
            $existingPetToys = $pet->getPetToys();

            foreach ($this->toys as $index => $toy) {
                $existingPetToy = $existingPetToys->filter(function(PetToy $petToy) use ($toy) {
                    return $petToy->getToy() === $toy;
                })->first();

                $petToy = $existingPetToy ?: (new PetToy())->setPet($pet)->setToy($toy);

                $form->add($index, PetToyFormType::class, [
                    'data' => $petToy,
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'pet' => null,
        ]);
    }

    public function getParent(): string
    {
        return CollectionType::class;
    }
}