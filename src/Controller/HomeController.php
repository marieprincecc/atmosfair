<?php

namespace App\Controller;


use App\Repository\OpinionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/{_locale<%app.supported_locales%>}")
*/
class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index( OpinionsRepository $opinionsRepository): Response
    {
        $opinions = $opinionsRepository->findForHome();
     

        return $this->render('home/index.html.twig',[
        'opinions'=>$opinions
        ]);
    }
}
