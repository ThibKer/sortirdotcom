<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{
    /**
     * @Route("/ville", name="ville")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Ville::class);
        $villes = $repo->findAll();
        return $this->render('ville/ville.html.twig', [
            'villes' => $villes
        ]);
    }

    /**
     * @Route("/ville/new/", name="new_ville")
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(VilleType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Ville $ville */
            $ville = $form->getData();
            $em->persist($ville);
            $em->flush();
            $this->addFlash('success', 'Ville modifier!');
            return $this->redirectToRoute('ville');
        }
        return $this->render('ville/ville_new.html.twig', [
            'formNew' => $form->createView()
        ]);
    }

    /**
     * @Route("/ville/update/{id}", name="update_ville", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request,Ville $ville): Response
    {
        $form = $this->createForm(VilleType::class, $ville);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->get('nom')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ville);
            $entityManager->flush();

            return $this->redirectToRoute('ville');
        }
        return $this->renderForm('ville/ville_update.html.twig', [
            'ville' => $ville,
            'formUpdate' => $form
        ]);
    }
    /**
     * @Route("/ville/remove/{id}", name="remove_ville")
     */
    public function removeVille(int $id) : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $ville = $entityManager->getRepository(Ville::class)->find($id);

        $entityManager->remove($ville);
        $entityManager->flush();

        return $this->redirectToRoute('ville', [
            'id' => $ville->getId()
        ]);

    }
}
