<?php

namespace App\Controller;

use App\Entity\Product;
use App\Search\SearchProduct;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/', name: 'product_index', methods: ['GET'])]
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
            'products' => $productRepository,
            'form' => $form->createView()
        ]);
        
    }

    #[Route('/{id}', name: 'product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        
        return $this->render('product/show.html.twig', [
            'product' => $product,
       
            ]);
        
        
    }
}
