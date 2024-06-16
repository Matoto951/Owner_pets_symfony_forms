<?php
namespace App\Twig\Components;

use App\Entity\Owner;
use App\Form\OwnerFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class OwnerForm extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public ?Owner $initialFormData = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(OwnerFormType::class, $this->initialFormData);
    }
}