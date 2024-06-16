<?php

namespace App\Controller;

use App\Entity\Owner;
use App\Form\OwnerFormType;
use App\Repository\OwnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OwnerController extends AbstractController
{
    #[Route('/', name: 'app_owner_index')]
    public function index(OwnerRepository $ownerRepository): Response
    {
        $owners = $ownerRepository->findAll();

        return $this->render('owner/index.html.twig', [
            'owners' => $owners
        ]);
    }
    #[Route('/new', name: 'app_owner_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $owner = new Owner();
        //$pet = new Pet();
        //$owner->addPet($pet);
        $form = $this->createForm(OwnerFormType::class, $owner);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($owner);
            $entityManager->flush();

            return $this->redirectToRoute('app_owner_index');
        }

        return $this->render('owner/new.html.twig', [
            'owner' => $owner,
            'form' => $form
        ]);
    }

    #[Route('/edit/{owner}', name: 'app_owner_edit')]
    public function edit(Owner $owner, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OwnerFormType::class, $owner);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_owner_index');
        }

        return $this->render('owner/edit.html.twig', [
            'owner' => $owner,
            'form' => $form
        ]);
    }

    #[Route('/delete/{owner}', name: 'app_owner_delete')]
    public function delete(Owner $owner, Request $request, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->getPayload()->get('token');
        if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            $entityManager->remove($owner);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_owner_index');
    }
}
