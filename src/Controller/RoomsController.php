<?php

namespace App\Controller;

use App\Entity\Rooms;
use App\Form\RoomsType;
use App\Repository\RoomsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rooms')]
class RoomsController extends AbstractController
{
    #[Route('/', name: 'rooms_index', methods: ['GET'])]
    public function index(RoomsRepository $roomsRepository): Response
    {
        return $this->render('rooms/index.html.twig', [
            'rooms' => $roomsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'rooms_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $room = new Rooms();
        $form = $this->createForm(RoomsType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->redirectToRoute('rooms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rooms/new.html.twig', [
            'room' => $room,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rooms_show', methods: ['GET'])]
    public function show(Rooms $room): Response
    {
        return $this->render('rooms/show.html.twig', [
            'room' => $room,
        ]);
    }

    #[Route('/{id}/edit', name: 'rooms_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rooms $room, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RoomsType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('rooms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rooms/edit.html.twig', [
            'room' => $room,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'rooms_delete', methods: ['POST'])]
    public function delete(Request $request, Rooms $room, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$room->getId(), $request->request->get('_token'))) {
            $entityManager->remove($room);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rooms_index', [], Response::HTTP_SEE_OTHER);
    }
}
