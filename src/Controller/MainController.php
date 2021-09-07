<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\ProfilFormType;
use App\Form\RegistrationFormType;
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
    public function home(): Response
    {
        $repositorySite = $this->getDoctrine()->getRepository(Site::class);
        $repositorySortie = $this->getDoctrine()->getRepository(Sortie::class);
        $sites = $repositorySite->findAll();
        $sorties = $repositorySortie->findAll();

        $sortiesInscrit = [];
        if ($this->getUser()) {
            $userEtat = 1;
            foreach ($this->getUser()->getSorties() as $sortieUser) {
                foreach ($sorties as $sortie){
                    if($sortieUser->getId() == $sortie->getId()){
                        array_push($sortiesInscrit, $sortie);
                    }
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
