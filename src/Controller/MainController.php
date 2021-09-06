<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('sortie/sortie.html.twig');
    }

    /**
     * @Route("/profil/{id}", name="profil")
     */
    public function profil(int $id): Response
    {
        return $this->render('sortie/sortie.html.twig');
    }
}
