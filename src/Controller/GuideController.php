<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/{_locale<%app.supported_locales%>}")
*/
class GuideController extends AbstractController
{
    #[Route('/guide', name: 'guide')]
    public function index(): Response
    {
        return $this->render('guide/index.html.twig');
    }
}
