<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Editor;
use Shiawa\BlogBundle\Form\EditorType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class EditorController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getManager();
        $editorRep = $em->getRepository('ShiawaBlogBundle:Editor');

        $nbPerPage = 5;

        $listEd = $editorRep->getEditors($page, $nbPerPage);
        $nbPage = ceil(count($listEd)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listEd) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:Editor:index.html.twig', array(
            'listEditor' => $listEd,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction($slug)
    {
        $editor = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Editor')
            ->findOneBySlug($slug);


        return $this->render('ShiawaBlogBundle:Editor:view.html.twig', array(
            'editor' => $editor
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $editor = new Editor();

        $form = $this->createForm(EditorType::class, $editor);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($editor);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Editeur bien enregistré');

            return $this->redirectToRoute('shiawa_editor_view', array(
                'slug' => $editor->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Editor:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction($slug, Request $request)
    {
        $editor = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Editor')
            ->findOneBySlug($slug);

        if (null === $editor) {
            throw new NotFoundHttpException("L'éditeur ".$slug." n'existe pas.");
        }

        $form = $this->createForm(EditorType::class, $editor);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($editor);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Editeur bien modifié');

            return $this->redirectToRoute('shiawa_editor_view', array(
                'slug' => $editor->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Editor:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $editor = $em->getRepository('ShiawaBlogBundle:Editor')->find($slug);

        if (null === $editor) {
            throw new NotFoundHttpException("L'éditeur ".$slug." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($editor);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "L'éditeur a bien été supprimé.");

            return $this->redirectToRoute('shiawa_homepage');
        }

        return $this->render('ShiawaBlogBundle:Editor:delete.html.twig', array(
            'editor' => $editor,
            'form'   => $form->createView(),
        ));
    }
}
