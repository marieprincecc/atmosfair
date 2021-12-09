<?php

namespace App\Controller;

use App\Repository\PollutingRepository;
use App\Repository\ProductRepository;
use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(RoomsRepository $roomsRepository, PollutingRepository $pollutingRepository, ProductRepository $productRepository): Response
    {   
        $rooms = $productRepository->findAll();

        $polluting = $pollutingRepository->findAll();

        $products = $productRepository->findBy([],null,8);
        
        return $this->render('home/index.html.twig', [
            'rooms' => $rooms,
            'polluting' => $polluting,
            'products' => $products
        ]);
    }
}
