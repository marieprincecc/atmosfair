<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Adress;
use App\Entity\Orderbuy;
use App\Form\AdressType;
use App\Form\OrderbuyType;
use App\Entity\Orderdetails;
use App\Repository\AdressRepository;
use App\Repository\OrderbuyRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\MesServices\CartService\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class OrderbuyController extends AbstractController
{
    #[Route('user/orderbuy', name: 'orderbuy_index', methods: ['GET'])]
    public function index(OrderbuyRepository $orderbuyRepository): Response
    {
        return $this->render('orderbuy/index.html.twig', [
            'orderbuys' => $orderbuyRepository->findAll(),
        ]);
    }

    #[Route('user/orderbuy/new', name: 'orderbuy_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CartService $cartService, EntityManagerInterface $entityManager): Response
    {
        $orderbuy = new Orderbuy();
       

        /** @var User $user */
        $user = $this->getUser();;
        $adressUser = $user->getAdress();

        if (!$adressUser) {
            $form = $this->createForm(AdressType::class, $adressUser);
            $form->handleRequest($request);
        }
      
        
        
        $orderbuy->setUser($user);
        $orderbuy->setTotal($cartService->getTotal());
        $orderbuy->setTotalTTC($cartService->getTotalTTC());
        $orderbuy->setAdressId($adressUser);
        $entityManager->persist($orderbuy);
        $entityManager->flush();
        
        $orderdetails = new Orderdetails();

         /** @var CartRealProduct[] $detailCart */
         $detailCart = $cartService->getDetailedCartItems();

         foreach ($detailCart as $item) {
            $orderdetails = new Orderdetails();
            $orderdetails->setProduct($item->getProduct());
            $orderdetails->setQuantity($item->getQty());
            $orderdetails->setOrderbuyId($orderbuy);
            $entityManager->persist($orderdetails);
         }

         $entityManager->flush();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($orderbuy);
            $entityManager->flush();

            return $this->redirectToRoute('customer_recap_order', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orderbuy/new.html.twig', [
            'orderbuy' => $orderbuy,
            'form' => $form,
        ]);
    }

    #[Route('user/orderbuy/{id}', name: 'orderbuy_show', methods: ['GET'])]
    public function show(Orderbuy $orderbuy): Response
    {
        return $this->render('orderbuy/show.html.twig', [
            'orderbuy' => $orderbuy,
        ]);
    }

    #[Route('user/orderbuy/{id}/edit', name: 'orderbuy_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orderbuy $orderbuy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderbuyType::class, $orderbuy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('orderbuy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('orderbuy/edit.html.twig', [
            'orderbuy' => $orderbuy,
            'form' => $form,
        ]);
    }

    #[Route('user/orderbuy/{id}/delete', name: 'orderbuy_delete', methods: ['POST'])]
    public function delete(Request $request, Orderbuy $orderbuy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderbuy->getId(), $request->request->get('_token'))) {
            $entityManager->remove($orderbuy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('orderbuy_index', [], Response::HTTP_SEE_OTHER);
    }
}
