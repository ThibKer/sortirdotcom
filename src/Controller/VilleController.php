<?php

namespace App\Controller;

use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/ville/new/")
     */
    public function update(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $ville = $entityManager->getRepository(Product::class);


        $product->setName('New product name!');
        $entityManager->flush();

        return $this->redirectToRoute('product_show', [
            'id' => $product->getId()
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
