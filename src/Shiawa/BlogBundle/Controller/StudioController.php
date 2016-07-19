<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Studio;
use Shiawa\BlogBundle\Form\StudioType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class StudioController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getManager();
        $studioRep = $em->getRepository('ShiawaBlogBundle:Studio');

        $nbPerPage = 5;

        $listStudio = $studioRep->getStudios($page, $nbPerPage);
        $nbPage = ceil(count($listStudio)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listStudio) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:Studio:index.html.twig', array(
            'listStudios' => $listStudio,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction($slug)
    {
        $studio = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Studio')
            ->findOneBySlug($slug);


        return $this->render('ShiawaBlogBundle:Studio:view.html.twig', array(
            'studio' => $studio
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $studio = new Studio();

        $form = $this->createForm(StudioType::class, $studio);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($studio);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Studio bien enregistré');

            return $this->redirectToRoute('shiawa_studio_view', array(
                'slug' => $studio->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Studio:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction($slug, Request $request)
    {
        $studio = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Studio')
            ->findOneBySlug($slug);

        if (null === $studio) {
            throw new NotFoundHttpException("Le studio ".$slug." n'existe pas.");
        }

        $form = $this->createForm(StudioType::class, $studio);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($studio);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Studio bien modifié');

            return $this->redirectToRoute('shiawa_studio_view', array(
                'slug' => $studio->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Episode:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $studio = $em->getRepository('ShiawaBlogBundle:Studio')->find($slug);

        if (null === $studio) {
            throw new NotFoundHttpException("Le studio ".$slug." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($studio);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "Le studio a bien été supprimé.");

            return $this->redirectToRoute('shiawa_homepage');
        }

        return $this->render('ShiawaBlogBundle:Studio:delete.html.twig', array(
            'studio' => $studio,
            'form'   => $form->createView(),
        ));
    }
}
