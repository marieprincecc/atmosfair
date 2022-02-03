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
use App\Repository\OrderdetailsRepository;
use App\MesServices\CartService\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/{_locale<%app.supported_locales%>}")
*/
class OrderbuyController extends AbstractController
{
    #[Route('user/orderbuy', name: 'orderbuy_index', methods: ['GET'])]
    public function index(OrderbuyRepository $orderbuyRepository): Response
    {   
        /** @var User $user */
        $user = $this->getUser();

        return $this->render('orderbuy/index.html.twig', [
            'orderbuys' => $orderbuyRepository->findByUser($user),
        ]);
    }

   

    #[Route('user/orderbuy/{id}', name: 'orderbuy_show', methods: ['GET'])]
    public function show(int $id, Orderbuy $orderbuy, OrderdetailsRepository $orderdetailsRepository): Response
    {  
        return $this->render('orderbuy/order_show.html.twig', [
            'orderbuy' => $orderbuy,
            'orderdetails' => $orderdetailsRepository->findByOrder($id),
        ]);
    }

   
   
}
