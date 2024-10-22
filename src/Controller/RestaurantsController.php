<?php

namespace App\Controller;

use App\Entity\Restaurants;
use App\Form\RestaurantsType;
use App\Repository\RestaurantsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/restaurants')]
final class RestaurantsController extends AbstractController
{
    #[Route(name: 'app_restaurants_index', methods: ['GET'])]
    public function index(RestaurantsRepository $restaurantsRepository): Response
    {
        return $this->render('restaurants/index.html.twig', [
            'restaurants' => $restaurantsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_restaurants_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $restaurant = new Restaurants();
        $form = $this->createForm(RestaurantsType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('app_restaurants_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('restaurants/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_restaurants_show', methods: ['GET'])]
    public function show(Restaurants $restaurant): Response
    {
        return $this->render('restaurants/show.html.twig', [
            'restaurant' => $restaurant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_restaurants_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Restaurants $restaurant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RestaurantsType::class, $restaurant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_restaurants_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('restaurants/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_restaurants_delete', methods: ['POST'])]
    public function delete(Request $request, Restaurants $restaurant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($restaurant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_restaurants_index', [], Response::HTTP_SEE_OTHER);
    }
}
