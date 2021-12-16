<?php

namespace App\Controller;

use App\Entity\Product;
use App\Search\SearchProduct;
use App\Form\SearchProductType;
use App\Repository\RoomsRepository;
use App\Repository\ProductRepository;
use App\Repository\PollutingRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product/liste', name: 'product_customer_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository, PaginatorInterface $paginator,Request $request): Response
    {

        $search = new SearchProduct();
        
        $form = $this->createForm(SearchProductType::class,$search);

        $form->handleRequest($request);

        $products = $paginator->paginate(
            $productRepository->findAllBySearchFilter($search),
            $request->query->getInt('page', 1),
            6
        );

        
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
        
    }

        /**
        * @Route("product/polluting/{id}", name="product_polluting_show")
        */
        public function productsByPolluting(int $id, PollutingRepository $pollutingRepository, ProductRepository $productRepository)
        {
        $polluting = $pollutingRepository->find($id);
        

        if(!$polluting)
        {
        return $this->redirectToRoute("product_customer_index");
        }

        return $this->render("polluting/show.html.twig",[
        'products' => $polluting->getProductId()
        ]);
        } 

         /**
        * @Route("product/room/{id}", name="product_room_show")
        */
        public function productsByRoom(int $id, RoomsRepository $roomsRepository, ProductRepository $productRepository)
        {
        $room = $roomsRepository->find($id);
        

        if(!$room)
        {
        return $this->redirectToRoute("product_customer_index");
        }

        return $this->render("rooms/show.html.twig",[
        'products' => $room->getProductId()
        ]);
        } 

    #[Route('product/detail/{id}', name: 'product_user_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        
        return $this->render('product/show.html.twig', [
            'product' => $product,
       
            ]);
        
        
    }
}
