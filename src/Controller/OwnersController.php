<?php

namespace App\Controller;

use App\Entity\Owners;
use App\Form\OwnersType;
use App\Repository\OwnersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/owners')]
final class OwnersController extends AbstractController
{
    #[Route(name: 'app_owners_index', methods: ['GET'])]
    public function index(OwnersRepository $ownersRepository): Response
    {
        return $this->render('owners/index.html.twig', [
            'owners' => $ownersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_owners_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $owner = new Owners();
        $form = $this->createForm(OwnersType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($owner);
            $entityManager->flush();

            return $this->redirectToRoute('app_owners_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('owners/new.html.twig', [
            'owner' => $owner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_owners_show', methods: ['GET'])]
    public function show(Owners $owner): Response
    {
        return $this->render('owners/show.html.twig', [
            'owner' => $owner,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_owners_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Owners $owner, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OwnersType::class, $owner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_owners_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('owners/edit.html.twig', [
            'owner' => $owner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_owners_delete', methods: ['POST'])]
    public function delete(Request $request, Owners $owner, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$owner->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($owner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_owners_index', [], Response::HTTP_SEE_OTHER);
    }
}
