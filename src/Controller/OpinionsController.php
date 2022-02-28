<?php

namespace App\Controller;

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

/**
* @Route("/{_locale<%app.supported_locales%>}")
*/
class OpinionsController extends AbstractController
{
    #[Route('/opinions/liste', name: 'opinions_index')]
    public function index(OpinionsRepository $opinionsRepository): Response
    {   $moyenne = $opinionsRepository->starsAvg();
      
        return $this->render('opinions/index.html.twig', [
            'opinions' => $opinionsRepository->findAll(),
            'moyenne' => round($moyenne[0][1]),
        ]);
    }

    #[Route('/opinions/new', name: 'opinions_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {   
        $opinion = new Opinions();
 $form = $this->createForm(OpinionsType::class, $opinion);
        $form->handleRequest($request);
        /** @var User $user */
        $user = $this->getUser();


        if ($form->isSubmitted() && $form->isValid()) {
            $opinion->setUser($user);
            $entityManager->persist($opinion);
            $entityManager->flush();

            return $this->redirectToRoute('opinions_index', [], Response::HTTP_SEE_OTHER);           
        }

        return $this->renderForm('opinions/new.html.twig', [
            'opinion' => $opinion,
            'form' => $form
        ]);
    }


   

    #[Route('opinions/edit/{id}', name: 'opinions_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Opinions $opinion, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OpinionsType::class, $opinion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('opinions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('opinions/edit.html.twig', [
            'opinion' => $opinion,
            'form' => $form,
        ]);
    }

    #[Route('/opinions/delete/{id}', name: 'opinions_delete', methods: ['POST'])]
    public function delete(Request $request, Opinions $opinion, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$opinion->getId(), $request->request->get('_token'))) {
            $entityManager->remove($opinion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('opinions_index', [], Response::HTTP_SEE_OTHER);
    }
}
