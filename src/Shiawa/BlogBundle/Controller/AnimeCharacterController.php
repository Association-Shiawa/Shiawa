<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\AnimeCharacter;
use Shiawa\BlogBundle\Form\AnimeCharacterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AnimeCharacterController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getManager();
        $charaRep = $em->getRepository('ShiawaBlogBundle:AnimeCharacter');

        $nbPerPage = 5;

        $listChars = $charaRep->getCharacters($page, $nbPerPage);
        $nbPage = ceil(count($listChars)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listChars) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:AnimeCharacter:index.html.twig', array(
            'listChars' => $listChars,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction($slug)
    {
        $char = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:AnimeCharacter')
            ->findOneBySlug($slug);


        return $this->render('ShiawaBlogBundle:AnimeCharacter:view.html.twig', array(
            'char' => $char
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $char = new AnimeCharacter();

        $form = $this->createForm(AnimeCharacterType::class, $char);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($char);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Personnage bien enregistré');

            return $this->redirectToRoute('shiawa_character_view', array(
                'slug' => $char->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:AnimeCharacter:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction($slug, Request $request)
    {
        $char = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:AnimeCharacter')
            ->findOneBySlug($slug);

        if (null === $char) {
            throw new NotFoundHttpException("Le Personnage ".$slug." n'existe pas.");
        }

        $form = $this->createForm(AnimeCharacterType::class, $char);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($char);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Personnage bien modifié');

            return $this->redirectToRoute('shiawa_character_view', array(
                'slug' => $char->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:AnimeCharacter:edit.html.twig', array(
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
