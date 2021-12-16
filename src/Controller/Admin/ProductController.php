<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Search\SearchProduct;
use App\Form\SearchProductType;
use App\Repository\ProductRepository;
use App\MesServices\HandleImageService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ProductController extends AbstractController
{
    #[Route('/admin/home', name: 'product_index')]
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

        
        return $this->render('admin_home/product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
        
    }

    #[Route('admin/new', name: 'product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,
                        HandleImageService $handleImageService): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
        
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();
            
            if(!$file)
            {
                $this->addFlash('danger','Veuillez ajouter une image.');
               return $this->redirectToRoute('product_new'); 
            }
            $handleImageService->save($file,$product);

            /** @var Polluting[] $pollutings  */
            $pollutings = $form->get('pollutings')->getData();
            if (count($pollutings)>0) {
                foreach ($pollutings as $polluting) {
                    $polluting->addProductId($product);
                }
            }

             /** @var Rooms[] $rooms  */
             $rooms = $form->get('rooms')->getData();
             if (count($rooms)>0) {
                 foreach ($rooms as $room) {
                     $room->addProductId($product);
                 }
             }
            $entityManager->persist($product);
            $entityManager->flush();
            
            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }

        return $this->renderForm('admin_home/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('admin/{id}', name: 'product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        
        return $this->render('admin_home/product/show.html.twig', [
            'product' => $product,
       
            ]);
        
        
    }

    #[Route('admin/{id}/edit', name: 'product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager, HandleImageService $handleImageService): Response
    {
        $form = $this->createForm(ProductType::class, $product);

        $originalImagePath = $product->getPathImage();

        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             /** @var UploadedFile $file */
            $file = $form->get('file')->getData();

            if($file)
            {
                $handleImageService->edit($file,$product,$originalImagePath);
            }

            $entityManager->flush();

            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_home/product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('admin/{id}', name: 'product_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }
}
