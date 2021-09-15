<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\RegistrationFormType;
use App\Util\Tri;
use Doctrine\ORM\Repository\RepositoryFactory;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\DateTime;

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
        $sortiesInscrit = [];
        $labelFiltre = "";
        $labelBuilder["tri_site"] = "";
        $labelBuilder["tri_checkbox_organisateur"] = "";
        $labelBuilder["tri_checkbox_passee"] = "";
        $labelBuilder["tri_date_debut"] = "";
        $labelBuilder["tri_date_fin"] = "";
        $labelBuilder["tri_checkbox_inscrit"] = "";
        $labelBuilder["tri_checkbox_non_inscrit"] = "";
        $labelBuilder["tri_texte"] = "";

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

            $sorties = [];
            $requeteDql = [];

            // Tri par Site
            if ($request->get("tri-site") != "0") {
                $requeteDql["site"] = $request->get("tri-site");
                $labelBuilder["tri_site"] = "Site '" . $repositorySite->find($request->get("tri-site"))->getNom() . "' | ";
            }

            // Tri des sorties qu'on organise
            if ($request->get("tri-checkbox-organisateur") !== null) {
                $requeteDql["organisateur"] = $this->getUser()->getId();
                $labelBuilder["tri_checkbox_organisateur"] = "Que j'organise | ";
            }

            // Tri des sorties "TERMINEE"
            if ($request->get("tri-checkbox-passee") !== null) {
                $requeteDql["etat"] = 6;
                $labelBuilder["tri_checkbox_passee"] = "Sortie(s) passée(s) | ";
            }

            // Requêtes préparé des 3 derniers tries
            $sorties = $repositorySortie->findBy($requeteDql);

            // Tri par la date de début
            if ($request->get("tri-date-debut") !== "") {

                $date = explode("-", $request->get("tri-date-debut"));
                $labelBuilder["tri_date_debut"] = "À partir du " . $date[2] . "/" . $date[1] . "/" . $date[0] . " | ";
                $timeStampDateChoisie = mktime(0, 0, 0, $date[1], $date[2], $date[0]);
                $toAdd = [];
                foreach ($sorties as $sortie) {
                    if ($sortie->getDateHeureDebut()->getTimestamp() > $timeStampDateChoisie) {
                        array_push($toAdd, $sortie);
                    }
                }
                $sorties = $toAdd;
            }

            // Tri par la date de fin
            if ($request->get("tri-date-fin") !== "") {
                $date = explode("-", $request->get("tri-date-fin"));
                $timeStampDateChoisie = mktime(0, 0, 0, $date[1], $date[2], $date[0]);
                $labelBuilder["tri_date_fin"] = "Jusqu'au " . $date[2] . "/" . $date[1] . "/" . $date[0] . " | ";
                $toAdd = [];
                foreach ($sorties as $sortie) {
                    if ($sortie->getDateHeureDebut()->getTimestamp() < $timeStampDateChoisie) {
                        array_push($toAdd, $sortie);
                    }
                }
                $sorties = $toAdd;
            }

            // Tri par sorties inscrit
            if ($request->get("tri-checkbox-inscrit") !== null) {
                $labelBuilder["tri_checkbox_inscrit"] = "Inscrit | ";
                $toAdd = [];
                foreach ($sorties as $sortie) {
                    foreach ($sortie->getParticipants() as $participant) {
                        if ($participant->getId() == $this->getUser()->getId()) {
                            array_push($toAdd, $sortie);
                        }
                    }
                }
                $sorties = $toAdd;
            }

            // Tri par sorties non inscrit
            if ($request->get("tri-checkbox-non-inscrit") !== null) {
                $labelBuilder["tri_checkbox_non_inscrit"] = "Non-inscrit | ";
                $toAdd = [];
                foreach ($sorties as $sortie) {
                    $userInscrit = false;
                    foreach ($sortie->getParticipants() as $participant) {
                        if ($participant->getId() == $this->getUser()->getId()) {
                            $userInscrit = true;
                        }
                    }
                    if (!$userInscrit) {
                        array_push($toAdd, $sortie);
                    }
                }
                $sorties = $toAdd;
            }

            // Tri par texte
            if ($request->get("tri-texte") != "") {
                $labelBuilder["tri_texte"] = "Recherche par '" . $request->get("tri-texte") . "' | ";
                $result = $repositorySortie->findWithName($request->get("tri-texte"));
                $toAdd = [];
                foreach ($sorties as $sortie) {
                    foreach ($result as $resultatSortie) {
                        if ($resultatSortie->getId() == $sortie->getId()) {
                            array_push($toAdd, $sortie);
                        }
                    }
                }
                $sorties = $toAdd;
            }

            // Enlever les sorties "SUPPRIMER" ou les "EN CREATION"
            $toAdd = [];
            foreach ($sorties as $sortie) {
                if ($sortie->getEtat()->getId() != 8 && $sortie->getEtat()->getId() != 1) {
                    array_push($toAdd, $sortie);
                }
            }
            $sorties = $toAdd;

            // Récupération sortie "En CREATION" de l'utilisateur
            $sortiesUtilisateur = $repositorySortie->findBy(["etat" => 1, "organisateur" => $this->getUser()->getId()]);
            foreach ($sortiesUtilisateur as $sortieUtilisateur) {
                array_push($sorties, $sortieUtilisateur);
            }

        } else {
            // Récupération de toutes les sorties hors celle en création
            $sorties = $repositorySortie->findBy(["etat" => [2, 3, 4, 5, 6, 7]]);

            // Liste des sorties dans lequel l'utilisateur courant est inscrit
            foreach ($this->getUser()->getSorties() as $sortieUser) {
                foreach ($sorties as $sortie) {
                    if ($sortieUser->getId() == $sortie->getId()) {
                        array_push($sortiesInscrit, $sortie);
                    }
                }
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

        }

        // Vérification temporelle de si nous devons mettre les états en "EN COURS" , "TERMINEE" et "INSCRIPTION FINIE"
        foreach ($sorties as $sortieCourante) {
            if ($sortieCourante->getEtat()->getId() == 2 ||
                $sortieCourante->getEtat()->getId() == 3 ||
                $sortieCourante->getEtat()->getId() == 4 ||
                $sortieCourante->getEtat()->getId() == 5) {
                // EN COURS
                if ($sortieCourante->getDateHeureDebut()->getTimestamp() <= time() &&
                    time() < ($sortieCourante->getDateHeureDebut()->getTimestamp() + ($sortieCourante->getDuree() * 60))) {
                    $sortieCourante->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(5));
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($sortieCourante);
                    $manager->flush();
                } // TERMINE
                elseif (($sortieCourante->getDateHeureDebut()->getTimestamp() + ($sortieCourante->getDuree()) * 60) <= time()) {
                    $sortieCourante->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(6));
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($sortieCourante);
                    $manager->flush();
                } // INSCRIPTION FINIE
                elseif ($sortieCourante->getDateLimiteInscription()->getTimestamp() < time()) {
                    $sortieCourante->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(4));
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($sortieCourante);
                    $manager->flush();
                }
            }

            // Vérification pour la mise en Etat "COMPLET"
            if ($sortieCourante->getEtat()->getId() == 2 &&
                count($sortieCourante->getParticipants()) >= $sortieCourante->getNbInscriptionMax() &&
                $sortieCourante->getDateLimiteInscription()->getTimestamp() >= time()) {
                $sortieCourante->setEtat($this->getDoctrine()->getRepository(Etat::class)->find(3));
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($sortieCourante);
                $manager->flush();
            }
        }

        //Liste sorties archivées
        $sortiesArchivees = [];
        $timestampDans1Mois = (time() - (31 * 24 * 60 * 60));
        foreach ($sorties as $sortie) {
            $timestampFinSortie = ($sortie->getDateHeureDebut()->getTimestamp() + $sortie->getDuree() * 60);
            if ($timestampFinSortie < $timestampDans1Mois) {
                array_push($sortiesArchivees, $sortie);
            }
        }

        // Gestion du message d'erreur en cas de problème de sécurité via le l'URL
        $error = "";
        if ($request->get("error") !== null) {
            $error = $request->get("error");
        }

        // Affichage filtre
        $labelFiltre = $labelBuilder["tri_site"] .
            $labelBuilder["tri_texte"] .
            $labelBuilder["tri_date_debut"] .
            $labelBuilder["tri_date_fin"] .
            $labelBuilder["tri_checkbox_organisateur"] .
            $labelBuilder["tri_checkbox_inscrit"] .
            $labelBuilder["tri_checkbox_non_inscrit"] .
            $labelBuilder["tri_checkbox_passee"];
        if (strchr($labelFiltre, "| ")) {
            $labelFiltre = substr($labelFiltre, 0, -2);
        }

        // Tri des sorties pour l'affichage
        usort($sorties, [ Tri::class , "triSorties"]);

        // Affichage page
        return $this->render('main/index.html.twig', [
            "sites" => $sites,
            "sorties" => $sorties,
            "sortiesInscit" => $sortiesInscrit,
            "sortiesArchivees" => $sortiesArchivees,
            "labelFiltre" => $labelFiltre,
            "error" => $error
        ]);
    }
}