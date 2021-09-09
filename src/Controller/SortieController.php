<?php

namespace App\Controller;
use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Sortie;
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
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Etat::class);

            $sortie->setOrganisateur($this->getUser());
            $sortie->setEtat($repository->find(1));


            $manager->persist($sortie);
            $manager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('sortie/sortieCreation.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/sortie/modifier/{id}", name="sortie_modifier", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function modificationSortie(Request $request,Sortie $sortie): Response
    {
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->get('nom')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }
        return $this->renderForm('sortie/sortieModification.html.twig', [
            'sortie' => $sortie,
            'formUpdate' => $form
        ]);

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

        $repo = $this->getDoctrine()->getRepository(Sortie::class);
        $sortie = $repo->find($id);
        $participants = $sortie->getParticipants();
        return $this->render('sortie/sortie.html.twig',
            [ 'sortie' => $sortie,
              'participants' => $participants]);
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
