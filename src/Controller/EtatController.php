<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtatController extends AbstractController
{
    /**
     * @Route("/etat", name="etat")
     */
    public function index(): Response
    {
        return $this->render('etat/etat.html.twig', [
            'controller_name' => 'EtatController',
        ]);
    }
}
