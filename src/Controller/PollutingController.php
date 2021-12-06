<?php

namespace App\Controller;

use App\Entity\Polluting;
use App\Form\PollutingType;
use App\Repository\PollutingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/polluting')]
class PollutingController extends AbstractController
{
    #[Route('/', name: 'polluting_index', methods: ['GET'])]
    public function index(PollutingRepository $pollutingRepository): Response
    {
        return $this->render('polluting/index.html.twig', [
            'pollutings' => $pollutingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'polluting_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $polluting = new Polluting();
        $form = $this->createForm(PollutingType::class, $polluting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($polluting);
            $entityManager->flush();

            return $this->redirectToRoute('polluting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('polluting/new.html.twig', [
            'polluting' => $polluting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'polluting_show', methods: ['GET'])]
    public function show(Polluting $polluting): Response
    {
        return $this->render('polluting/show.html.twig', [
            'polluting' => $polluting,
        ]);
    }

    #[Route('/{id}/edit', name: 'polluting_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Polluting $polluting, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PollutingType::class, $polluting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('polluting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('polluting/edit.html.twig', [
            'polluting' => $polluting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'polluting_delete', methods: ['POST'])]
    public function delete(Request $request, Polluting $polluting, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$polluting->getId(), $request->request->get('_token'))) {
            $entityManager->remove($polluting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('polluting_index', [], Response::HTTP_SEE_OTHER);
    }
}
