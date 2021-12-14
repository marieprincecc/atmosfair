<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Opinions;
use App\Form\OpinionsType;
use App\Repository\OpinionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\security;


class OpinionsController extends AbstractController
{
    #[Route('admin/opinions/liste', name: 'admin_opinions_index', methods: ['GET'])]
    public function index(OpinionsRepository $opinionsRepository): Response
    {   
        return $this->render('admin_home/opinions/index.html.twig', [
            'opinions' => $opinionsRepository->findAll(),
        ]);
    }



    #[Route('admin/opinions/delete/{id}', name: 'admin_opinions_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Opinions $opinion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$opinion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($opinion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_opinions_index', [], Response::HTTP_SEE_OTHER);
    }
}
