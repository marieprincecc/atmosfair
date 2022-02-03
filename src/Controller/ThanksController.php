<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/{_locale<%app.supported_locales%>}")
*/
class ThanksController extends AbstractController
{
    #[Route('/thanks', name: 'thanks')]
    public function index(): Response
    {
        return $this->render('thanks/index.html.twig');
    }
}
