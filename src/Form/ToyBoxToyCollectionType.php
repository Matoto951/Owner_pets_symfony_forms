<?php

namespace App\Form;

use App\Entity\ToyBox;
use App\Entity\ToyBoxToy;
use App\Entity\Toy;
use App\Repository\ToyRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToyBoxToyCollectionType extends AbstractType
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
            /** @var ToyBox $toyBox */
            $toyBox = $options['toyBox'];
            $existingPetToys = $toyBox->getToyBoxToys();

            foreach ($this->toys as $index => $toy) {
                $existingPetToy = $existingPetToys->filter(function(ToyBoxToy $petToy) use ($toy) {
                    return $petToy->getToy() === $toy;
                })->first();

                $toxBoyToy = $existingPetToy ?: (new ToyBoxToy())->setToyBox($toyBox)->setToy($toy);

                $form->add($index, ToyBoxToyFormType::class, [
                    'data' => $toxBoyToy,
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'pet' => null,
            'toyBox' => null,
        ]);
    }

    public function getParent(): string
    {
        return CollectionType::class;
    }
}