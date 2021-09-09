<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\RegistrationFormType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request): Response
    {
        $repositorySite = $this->getDoctrine()->getRepository(Site::class);
        $repositorySortie = $this->getDoctrine()->getRepository(Sortie::class);
        $sites = $repositorySite->findAll();

        //Tri
        if (($request->get("tri-site") !== null) || (
            $request->get("tri-site" != "0") &&
            $request->get("tri-texte" != "") &&
            $request->get("tri-date-debut" != "") &&
            $request->get("tri-date-fin" != "") &&
            $request->get("tri-checkbox-organisateur" !== null) &&
            $request->get("tri-checkbox-inscrit" !== null) &&
            $request->get("tri-checkbox-non-inscrit" !== null) &&
            $request->get("tri-checkbox-passee" !== null)
            )) {

            $requeteDql = [];

            if ($request->get("tri-site") != "0") {
                $requeteDql["site"] = $request->get("tri-site");
            }

            if ($request->get("tri-checkbox-organisateur") !== null) {
                $requeteDql["organisateur"] = $this->getUser()->getId();
            }

            if ($request->get("tri-checkbox-inscrit") !== null) {
//                $requeteDql["participants"] = $this->getUser()->getId();
            }

            if ($request->get("tri-checkbox-non-inscrit") !== null) {
//                $requeteDql[""] = ;
            }

            if ($request->get("tri-checkbox-passee") !== null) {
                $requeteDql["etat"] = 5;
            }

            $sorties = $repositorySortie->findBy($requeteDql);

        } else {
            $sorties = $repositorySortie->findBy(["etat" => [2, 3, 4, 5, 6]], ["etat" => "ASC"]);
        }

        // Affichage des sorties non publiées si c'est le notre
        $sortiesOrganiser = $repositorySortie->findBy(["etat" => 1, "organisateur" => $this->getUser()]);
        if (count($sortiesOrganiser) > 0) {
            foreach ($sortiesOrganiser as $sortie) {
                $dejaexistant = false;
                foreach ($sorties as $sorti) {
                    if ($sorti->getId() == $sortie->getId()) {
                        $dejaexistant = true;
                    }
                }
                if (!$dejaexistant) {
                    array_push($sorties, $sortie);
                }
            }
        }

        // Vérification des Etat "EN COURS" et "TERMINE"
        foreach ($sorties as $sortieCourante) {
            if ($sortieCourante->getEtat()->getId() != 1 ||
                $sortieCourante->getEtat()->getId() != 5 ||
                $sortieCourante->getEtat()->getId() != 6) {
                // EN COURS
                if ($sortieCourante->getDateHeureDebut()->getTimestamp() <= time() &&
                    time() < ($sortieCourante->getDateHeureDebut()->getTimestamp() + ($sortieCourante->getDuree() * 60))) {
                    $sortieCourante->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(4));
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($sortieCourante);
                    $manager->flush();
                } // TERMINE
                elseif (($sortieCourante->getDateHeureDebut()->getTimestamp() + ($sortieCourante->getDuree()) * 60) <= time()) {
                    $sortieCourante->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(5));
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($sortieCourante);
                    $manager->flush();
                }
            }
            if ($sortieCourante->getEtat()->getId() == 3 &&
                count($sortieCourante->getParticipants()) < $sortieCourante->getNbInscriptionMax()) {
                $sortieCourante->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(2));
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($sortieCourante);
                $manager->flush();
            }
        }

        // Liste des sorties dans lequel l'utilisateur courant est inscrit
        $sortiesInscrit = [];
        foreach ($this->getUser()->getSorties() as $sortieUser) {
            foreach ($sorties as $sortie) {
                if ($sortieUser->getId() == $sortie->getId()) {
                    array_push($sortiesInscrit, $sortie);
                }
            }
        }

        return $this->render('main/index.html.twig', [
            "sites" => $sites,
            "sorties" => $sorties,
            "sortiesInscit" => $sortiesInscrit
        ]);
    }
}
