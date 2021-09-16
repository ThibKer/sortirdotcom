<?php

namespace App\Controller;

use App\Entity\AnnulationSortie;
use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Form\LieuType;
use App\Form\ModifierSortieType;
use App\Form\SortieLieuType;
use App\Form\SortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class SortieController extends AbstractController
{

    /**
     * @Route("/sortie/creer", name="sortie_creer")
     */
    public function creationSortie(Request $request, SerializerInterface $serializer): Response
    {
        $sortie = new Sortie();
        $formSortie = $this->createForm(SortieType::class, $sortie);
        $formSortie->handleRequest($request);
        $error = "";
        if ($request->get('error') !== null) {
            $error = $request->get('error');
        }

        if ($formSortie->isSubmitted() && $formSortie->isValid()) {

            if (($sortie->getDateHeureDebut()->getTimestamp() < $sortie->getDateLimiteInscription()->getTimestamp()) ||
                ($sortie->getDateLimiteInscription()->getTimestamp() < time())) {
                return $this->redirectToRoute('sortie_creer', [
                    "error" => "Erreur sur les dates"
                ]);
            }
            $manager = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Etat::class);

            $sortie->setOrganisateur($this->getUser());
            $sortie->setEtat($repository->find(1));

            $manager->persist($sortie);
            $manager->flush();
            return $this->redirectToRoute('home');
        }


        $repositoryLieu = $this->getDoctrine()->getRepository(Lieu::class);
        $lieux = $repositoryLieu->findAll();

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getNom();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        $lieuxDonneesJSON = $serializer->serialize($lieux, 'json', [
            'ignored_attributes' => ['sorties'
            ]]);

        $repositoryVille = $this->getDoctrine()->getRepository(Ville::class);
        $villes = $repositoryVille->findAll();

        return $this->render('sortie/sortieCreation.html.twig', [
            "formSortie" => $formSortie->createView(),
            "lieuxdonnees" => $lieuxDonneesJSON,
            "villes" => $villes,
            "error" => $error
        ]);
    }

    /**
     * @Route("/sortie/creer/lieu", name="sortie_creer_lieu")
     */
    public function creationSortieSupp(Request $request): Response
    {
        $sortie = new Sortie();
        $formSortie = $this->createForm(SortieLieuType::class, $sortie);
        $formSortie->handleRequest($request);
        $error = "";
        if ($request->get('error') !== null) {
            $error = $request->get('error');
        }

        if ($formSortie->isSubmitted() && $formSortie->isValid()) {

            if (($sortie->getDateHeureDebut()->getTimestamp() < $sortie->getDateLimiteInscription()->getTimestamp()) ||
                ($sortie->getDateLimiteInscription()->getTimestamp() < time())) {
                return $this->redirectToRoute('sortie_creer_lieu', [
                    "error" => "Erreur sur les dates"
                ]);
            }

            $manager = $this->getDoctrine()->getManager();
            $repository = $this->getDoctrine()->getRepository(Etat::class);

            $sortie->setOrganisateur($this->getUser());
            $sortie->setEtat($repository->find(1));


            $manager->persist($sortie->getLieu());
            $manager->persist($sortie);
            $manager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('sortie/sortieCreationAvecLieu.html.twig', [
            "formSortie" => $formSortie->createView(),
            "error" => $error
        ]);
    }

    /**
     * @Route("/sortie/modifier/{id}", name="sortie_modifier", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function modificationSortie(Request $request, SerializerInterface $serializer, Sortie $sortie): Response
    {
        // Si la sortie n'est pas encore publiée
        if ($sortie->getOrganisateur()->getId() == $this->getUser()->getId() &&
            $sortie->getEtat()->getId() == 1) {

            // Création formulaire Sortie
            $form = $this->createForm(SortieType::class, $sortie);
            $form->handleRequest($request);

            // Initialisation potientiel erreur
            $error = "";

            // Vérification formulaire submit et valide
            if ($form->isSubmitted()) {

                if($request->get('hidden-data-ajout') != "" &&
                $request->get('id-choix-lieu') == 0) {
                    try {
                        $data = $request->get('hidden-data-ajout');
//                $data = substr($data, 1, strlen($data));
//                $data = substr($data, 0, -1);
                        $newLieu = $serializer->deserialize($data, Lieu::class, 'json');

                        $repositoryVille = $this->getDoctrine()->getRepository(Ville::class);
                        $ville = $repositoryVille->findBy(["nom" => $newLieu->getVille()->getNom()])[0];
                        $newLieu->setVille($ville);
                        $newLieu->addSorty($sortie);

                        $manager = $this->getDoctrine()->getManager();
                        $manager->persist($newLieu);
                        $manager->persist($sortie);
                        $manager->persist($ville);

                        $manager->flush();
                    }catch (\Exception $e){
                        return $this->redirectToRoute('sortie_modifier', [
                            "id" => $sortie->getId(),
                        ]);
                    }
                }

                if ($form->isValid() || $request->get('hidden-data-ajout') != "") {
                    // Vérification des dates
                    if (($sortie->getDateHeureDebut()->getTimestamp() < $sortie->getDateLimiteInscription()->getTimestamp()) ||
                        ($sortie->getDateLimiteInscription()->getTimestamp() < time())) {
                        $error = "Erreur sur les dates";
                        return $this->redirectToRoute('sortie_modifier', [
                            "id" => $sortie->getId()
                        ]);
                    } else {
                        $form->get('nom')->getData();

                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($sortie);
                        $entityManager->flush();

                        return $this->redirectToRoute('home');
                    }
                }
            }

            // Passage des données de lieux en JSON
            $repositoryLieu = $this->getDoctrine()->getRepository(Lieu::class);
            $lieux = $repositoryLieu->findAll();
            $encoder = new JsonEncoder();
            $defaultContext = [
                AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                    return $object->getNom();
                },
            ];
            $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
            $serializer = new Serializer([$normalizer], [$encoder]);
            $lieuxDonneesJSON = $serializer->serialize($lieux, 'json', [
                'ignored_attributes' => ['sorties'
                ]]);


            // Récupération des villes
            $repositoryVille = $this->getDoctrine()->getRepository(Ville::class);
            $villes = $repositoryVille->findAll();

            // Formulaire des lieux
            $lieu = new Lieu();
            $formLieu = $this->createForm(LieuType::class, $lieu);
            $formLieu->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                dd($lieu);
            }

            return $this->renderForm('sortie/sortieModification.html.twig', [
                'sortie' => $sortie,
                "villes" => $villes,
                'formUpdate' => $form,
                'formLieu' => $formLieu,
                "lieuxdonnees" => $lieuxDonneesJSON,
                "error" => $error
            ]);
        } else {
            return $this->redirectToRoute('home', [
                "error" => "Erreur, Modification impossible"
            ]);
        }
    }

    /**
     * @Route("/sortie/modifier/lieu/{id}", name="sortie_modifier_lieu", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function modificationLieuSortie(Request $request, Sortie $sortie): Response
    {
        if ($sortie->getOrganisateur()->getId() == $this->getUser()->getId() &&
            $sortie->getEtat()->getId() == 1) {
            $formSortie = $this->createForm(ModifierSortieType::class, $sortie);
            $formSortie->handleRequest($request);
            $error = "";

            $lieu = new Lieu();
            $formLieu = $this->createForm(LieuType::class, $lieu);
            $formLieu->handleRequest($request);

            if ($formSortie->isSubmitted() && $formSortie->isValid()) {

                if (($sortie->getDateHeureDebut()->getTimestamp() < $sortie->getDateLimiteInscription()->getTimestamp()) ||
                    ($sortie->getDateLimiteInscription()->getTimestamp() < time())) {
                    $error = "Erreur sur les dates";
                }

                $sortie->setLieu($lieu);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($lieu);
                $entityManager->persist($sortie);
                $entityManager->flush();

                return $this->redirectToRoute('home');
            }
            return $this->renderForm('sortie/sortieModificationAvecLieu.html.twig', [
                'sortie' => $sortie,
                'formUpdate' => $formSortie,
                'formLieu' => $formLieu,
                'error' => $error
            ]);
        } else {
            return $this->redirectToRoute('home', [
                "error" => "Erreur, Modification impossible"
            ]);
        }
    }

    /**
     * @Route("/sortie/annuler/{id}", name="sortie_annuler")
     */
    public function annulationSortie(Sortie $sortie, Request $request): Response
    {
        if ($sortie->getOrganisateur()->getId() == $this->getUser()->getId() &&
            $sortie->getEtat()->getId() == 2) {
            if ($request->get("annulation-motif") !== null) {
                $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(7));
                $annulation = new AnnulationSortie();
                $annulation->setLibelle($request->get("annulation-motif"));
                $annulation->setSortie($sortie);
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($annulation);
                $manager->persist($sortie);
                $manager->flush();
                return $this->redirectToRoute("home");
            }
            return $this->render('sortie/sortieAnnulation.html.twig', [
                "sortie" => $sortie
            ]);
        } else {
            return $this->redirectToRoute("home", [
                "error" => "Annulation impossible"
            ]);
        }
    }

    /**
     * @Route("/sortie/details/{id}", name="sortie_details")
     */
    public function detailsSortie(Sortie $sortie): Response
    {
        $timestampFinSortie = ($sortie->getDateHeureDebut()->getTimestamp() + $sortie->getDuree() * 60);
        $timestampDans1Mois = (time() - (31 * 24 * 60 * 60));
        if ($timestampFinSortie < $timestampDans1Mois || $sortie->getEtat()->getId() == 8) {
            return $this->redirectToRoute('home', [
                "error" => "Erreur, sortie archivée"
            ]);
        } elseif ($sortie->getEtat()->getId() == 1 && $this->getUser()->getId() != $sortie->getOrganisateur()->getId()) {
            return $this->redirectToRoute('home', [
                "error" => "Erreur, sortie non publiée"
            ]);
        } else {
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

        // Liste des sorties dans lequel l'utilisateur est inscrit
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

        // Pour empêcher l'inscription dans une sortie en dehors de l'etat "OUVERT" ou "COMPLET"
        if (!$participantInscrit && ($sortie->getEtat()->getId() != 2 && $sortie->getEtat()->getId() != 3)) {
            $autorisationInscitpion = false;
        }

        if ($autorisationInscitpion) {
            if ($participantInscrit) {
                $this->getUser()->removeSorty($sortie);
            } else {
                $this->getUser()->addSorty($sortie);
            }

            // Vérification Etat "INSCRIPTION FINIES"
            if (count($sortie->getParticipants()) > $sortie->getNbInscriptionMax()) {
                $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(3));
            } else {
                $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(2));
            }

            $manager->persist($sortie);
            $manager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->redirectToRoute('home', [
            "error" => "Inscription / Désinscription impossible"
        ]);
    }

    /**
     * @Route("/sortie/publication/{id}", name="sortie_publication")
     */
    public function publicationSortie(Sortie $sortie): Response
    {
        if ($sortie->getOrganisateur()->getId() == $this->getUser()->getId() && $sortie->getEtat()->getId() == 1) {
            $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(2));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($sortie);
            $manager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->redirectToRoute('home', [
            "error" => "Erreur, sortie non publiable"
        ]);
    }

    /**
     * @Route("/sortie/suppression/{id}", name="sortie_suppression")
     */
    public function suppressionSortie(Sortie $sortie): Response
    {
        if ($sortie->getEtat()->getId() == 1 && $sortie->getOrganisateur()->getId() == $this->getUser()->getId()) {
            $sortie->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(8));
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($sortie);
            $manager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->redirectToRoute('home', [
            "error" => "Erreur, sortie non supprimable"
        ]);
    }
}
