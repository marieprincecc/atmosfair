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

   

    #[Route('user/orderbuy/{id}', name: 'orderbuy_show', methods: ['GET'])]
    public function show(Orderbuy $orderbuy): Response
    {
        return $this->render('orderbuy/show.html.twig', [
            'orderbuy' => $orderbuy,
        ]);
    }

   
   
}
