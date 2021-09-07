<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Sortie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{

    /**
     * @Route("/sortie/creer", name="sortie_creer")
     */
    public function creationSortie(): Response
    {
        return $this->render('sortie/sortieCreation.html.twig');
    }

    /**
     * @Route("/sortie/modifier", name="sortie_modifier")
     */
    public function modificationSortie(): Response
    {
        return $this->render('sortie/sortieModification.html.twig');
    }

    /**
     * @Route("/sortie/annuler", name="sortie_annuler")
     */
    public function annulationSortie(): Response
    {
        return $this->render('sortie/sortieAnnulation.html.twig');
    }

    /**
     * @Route("/sortie/details/{id}", name="sortie_details")
     */
    public function detailsSortie(int $id): Response
    {
        return $this->render('sortie/sortie.html.twig');
    }

    /**
     * @Route("/sortie/gestioninscription/{id}", name="sortie_inscription")
     */
    public function gestionInscription(Sortie $sortie): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $inscrit = $this->getUser()->getSorties();
        $trouver = false;
        foreach ($inscrit as $sortieInscrit) {
            if($sortie->getId() == $sortieInscrit->getId()){
                $trouver = true;
            }
        }
        if($trouver){
            $this->getUser()->removeSorty($sortie);
        } else {
            $this->getUser()->addSorty($sortie);
        }
        $manager->persist($sortie);
        $manager->flush();
        return $this->redirectToRoute('home');
    }
}
