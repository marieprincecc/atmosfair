<?php

namespace App\Controller\Admin;

use App\Entity\Orderdetails;
use App\Form\OrderdetailsType;
use App\Repository\OrderdetailsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderdetailsController extends AbstractController
{   

    #[Route('admin/orderdetails/{id}/edit', name: 'admin_orderdetails_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orderdetails $orderdetail, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderdetailsType::class, $orderdetail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('orderdetails_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/orderdetails/edit.html.twig', [
            'orderdetail' => $orderdetail,
            'form' => $form,
        ]);
    }

    
}
