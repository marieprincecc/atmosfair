<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/{_locale<%app.supported_locales%>}")
*/
class CgvController extends AbstractController
{
    #[Route('/cgv', name: 'cgv')]
    public function index(): Response
    {
        return $this->render('cgv/index.html.twig');
    }
}
