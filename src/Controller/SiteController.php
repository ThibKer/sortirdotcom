<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/site", name="site")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Site::class);
        $sites = $repo->findAll();
        return $this->render('site/site.html.twig', [
            'sites' => $sites
        ]);
    }
    /**
     * @Route("/site/new/", name="new_site")
     */
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SiteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Site $site */
            $site = $form->getData();
            $em->persist($site);
            $em->flush();
            $this->addFlash('success', 'Site modifier!');
            return $this->redirectToRoute('site');
        }
        return $this->render('site/site_new.html.twig', [
            'formNew' => $form->createView()
        ]);
    }

    /**
     * @Route("/site/update/{id}", name="update_site", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Request $request,Site $site): Response
    {
        $form = $this->createForm(SiteType::class, $site);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->get('nom')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($site);
            $entityManager->flush();

            return $this->redirectToRoute('site');
        }
        return $this->renderForm('site/site_update.html.twig', [
            'site' => $site,
            'formUpdate' => $form
        ]);
    }
    /**
     * @Route("/site/remove/{id}", name="remove_site")
     */
    public function removeSite(int $id) : Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $site = $entityManager->getRepository(Site::class)->find($id);

        $entityManager->remove($site);
        $entityManager->flush();

        return $this->redirectToRoute('site', [
            'id' => $site->getId()
        ]);

    }
}
