<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Anime;
use Shiawa\BlogBundle\Form\AnimeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AnimeController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getManager();
        $animeRep = $em->getRepository('ShiawaBlogBundle:Anime');

        $nbPerPage = 16;

        $listAnimes = $animeRep->getAnimes($page, $nbPerPage);
        $nbPage = ceil(count($listAnimes)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listAnimes) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:Anime:index.html.twig', array(
            'listAnimes' => $listAnimes,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction($slug)
    {
        $anime = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Anime')
            ->findOneBySlug($slug);


        return $this->render('ShiawaBlogBundle:Anime:view.html.twig', array(
            'anime' => $anime
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $anime = new Anime();
        $anime->setCreatedAt(new \Datetime());

        $form = $this->createForm(AnimeType::class, $anime);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($anime);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Anime bien enregistré');

            return $this->redirectToRoute('shiawa_anime_view', array(
                'slug' => $anime->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Anime:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction($slug, Request $request)
    {
        $anime = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Anime')
            ->findOneBySlug($slug);

        if (null === $anime) {
            throw new NotFoundHttpException("L'anime ".$slug." n'existe pas.");
        }

        $form = $this->createForm(AnimeType::class, $anime);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($anime);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Anime bien modifié');

            return $this->redirectToRoute('shiawa_anime_view', array(
                'slug' => $anime->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Anime:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $anime = $em->getRepository('ShiawaBlogBundle:Anime')->find($slug);

        if (null === $anime) {
            throw new NotFoundHttpException("L'anime ".$slug." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($anime);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "L'anime a bien été supprimé.");

            return $this->redirectToRoute('shiawa_homepage');
        }

        return $this->render('ShiawaBlogBundle:Anime:delete.html.twig', array(
            'anime' => $anime,
            'form'   => $form->createView(),
        ));
    }

    public function newsAction()
    {
        $lastAnimes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Anime')
            ->getNew()
        ;

        return $this->render('ShiawaBlogBundle:Anime:new_anime.html.twig', array(
            'lastAnimes' => $lastAnimes
        ));
    }
}
