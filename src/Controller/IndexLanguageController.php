<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexLanguageController extends AbstractController
{
    /**
     * @Route("/", name="index_language")
     */
    public function index(Request $request): Response
    {
       
        $language = $request->getLocale();
        return $this->redirectToRoute('home',['_locale' => $language]);
    }
}