<?php

namespace App\Controller\Admin;

use App\Entity\Orderbuy;
use App\Form\OrderbuyType;
use App\Repository\OrderbuyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OrderbuyController extends AbstractController
{
    #[Route('admin/orderbuy', name: 'admin_orderbuy_index', methods: ['GET'])]
    public function index(OrderbuyRepository $orderbuyRepository): Response
    {
        return $this->render('admin_home/orderbuy/index.html.twig', [
            'orderbuys' => $orderbuyRepository->findAll(),
        ]);
    }


    #[Route('admin/orderbuy/{id}', name: 'admin_orderbuy_show', methods: ['GET'])]
    public function show(Orderbuy $orderbuy): Response
    {
        return $this->render('admin_home/orderbuy/show.html.twig', [
            'orderbuy' => $orderbuy,
        ]);
    }

    #[Route('admin/orderbuy/{id}/edit', name: 'admin_orderbuy_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orderbuy $orderbuy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderbuyType::class, $orderbuy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_orderbuy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_home/orderbuy/edit.html.twig', [
            'orderbuy' => $orderbuy,
            'form' => $form,
        ]);
    }

    #[Route('admin/orderbuy/{id}/delete', name: 'admin_orderbuy_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Orderbuy $orderbuy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderbuy->getId(), $request->request->get('_token'))) {
            $entityManager->remove($orderbuy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_orderbuy_index', [], Response::HTTP_SEE_OTHER);
    }
}
