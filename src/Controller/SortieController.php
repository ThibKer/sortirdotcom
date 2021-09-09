<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\LieuType;
use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{

    /**
     * @Route("/sortie/creer", name="sortie_creer")
     */
    public function creationSortie(Request $request): Response
    {
        $sortie = new Sortie();
        $formSortie = $this->createForm(SortieType::class, $sortie);
        $formSortie->handleRequest($request);

        if ($formSortie->isSubmitted() && $formSortie->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Etat::class);

            $sortie->setOrganisateur($this->getUser());
            $sortie->setEtat($repository->find(1));


            $manager->persist($sortie->getLieu());
            $manager->persist($sortie);
            $manager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('sortie/sortieCreation.html.twig', [
            "formSortie" => $formSortie->createView()
        ]);
    }

    /**
     * @Route("/sortie/modifier", name="sortie_modifier")
     */
    public function modificationSortie(): Response
    {
        return $this->render('sortie/sortieModification.html.twig');
    }

    /**
     * @Route("/sortie/annuler/{id}", name="sortie_annuler")
     */
    public function annulationSortie(Sortie $sortie): Response
    {
        if($sortie->getOrganisateur()->getId() == $this->getUser()->getId()){
            return $this->render('sortie/sortieAnnulation.html.twig', [
                "sortie" => $sortie
            ]);
        } else {
            return $this->redirectToRoute("home");
        }
    }

    /**
     * @Route("/sortie/details/{id}", name="sortie_details")
     */
    public function detailsSortie(int $id): Response
    {
        $repo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $repo->find($id);
        $timestampFinSortie = ($sortie->getDateHeureDebut()->getTimestamp() + $sortie->getDuree() * 60);
        $timestampDans1Mois = (time() - (31 * 24 * 60 * 60));
        if ($timestampFinSortie < $timestampDans1Mois) {
            return $this->redirectToRoute('home');
        } else{
            $participants = $sortie->getParticipants();
            return $this->render('sortie/sortie.html.twig',
                ['sortie' => $sortie,
                'participants' => $participants]);
        }
    }

    /**
     * @Route("/sortie/gestioninscription/{id}", name="sortie_inscription")
     */
    public function gestionInscription(Sortie $sortie): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $inscrit = $this->getUser()->getSorties();
        $participantInscrit = false;
        foreach ($inscrit as $sortieInscrit) {
            if ($sortie->getId() == $sortieInscrit->getId()) {
                $participantInscrit = true;
            }
        }

        $autorisationInscitpion = true;

        // Pour empêcher l'inscription de l'organisateur
        if ($sortie->getOrganisateur()->getId() == $this->getUser()->getId()) {
            $autorisationInscitpion = false;
        }

        // Pour empêcher l'inscription dans une sortie pleine
        if (count($sortie->getParticipants()) >= $sortie->getNbInscriptionMax() && !$participantInscrit) {
            $autorisationInscitpion = false;
        }

        // Pour empêcher l'inscription dans une sortie CREER / CLOTURER / EN COURS / TERMINER / ANNULER
        if (!$participantInscrit && $sortie->getEtat()->getId() != 2) {
            $autorisationInscitpion = false;
        }

        if (($participantInscrit && $sortie->getEtat()->getId() == 4) ||
            ($participantInscrit && $sortie->getEtat()->getId() == 5) ||
            ($participantInscrit && $sortie->getEtat()->getId() == 6)) {
            $autorisationInscitpion = false;
        }

        if ($autorisationInscitpion) {
            if ($participantInscrit) {
                $this->getUser()->removeSorty($sortie);
            } else {
                $this->getUser()->addSorty($sortie);
            }

            // Vérification Etat "CLOTURER"
            if (count($sortie->getParticipants()) < $sortie->getNbInscriptionMax()) {
                $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(3));
            } else {
                $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(2));
            }

            $manager->persist($sortie);
            $manager->flush();
        }
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/sortie/publication/{id}", name="sortie_publication")
     */
    public function publicationSortie(Sortie $sortie): Response
    {
        $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(2));
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($sortie);
        $manager->flush();
        return $this->redirectToRoute('home');
    }
}
