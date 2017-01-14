<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Formation;
use Shiawa\BlogBundle\Form\FormationEditType;
use Shiawa\BlogBundle\Form\FormationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class FormationController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getManager();
        $formationRep = $em->getRepository('ShiawaBlogBundle:Formation');

        $nbPerPage = 9;

        $listFormations = $formationRep->getFormations($page, $nbPerPage);
        $nbPage = ceil(count($listFormations)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listFormations) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:Formation:index.html.twig', array(
            'listFormations' => $listFormations,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction($category, $slug)
    {
        $formation = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Formation')
            ->findOneBySlug($slug);

        return $this->render('ShiawaBlogBundle:Formation:view.html.twig', array(
            'formation' => $formation
        ));
    }

    /**
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $formation = new Formation();
        $formation->setCreatedAt(new \Datetime());

        $form = $this->createForm(FormationType::class, $formation);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $tagsManagement = $this->get('shiawa_blog.tags');
            $tagsManagement->setArticleTags($formation);

            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Formation bien enregistrée');

            return $this->redirectToRoute('shiawa_formation_edit', array(
                'slug' => $formation->getSlug(),
                'category' => $formation->getCategory()->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Formation:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction($slug, Request $request)
    {
        $formation = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Formation')
            ->findOneBySlug($slug);

        if (null === $formation) {
            throw new NotFoundHttpException("La formation ".$slug." n'existe pas.");
        }

        $form = $this->createForm(FormationEditType::class, $formation);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $tagsManagement = $this->get('shiawa_blog.tags');
            $tagsManagement->setArticleTags($formation);

            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Formation bien modifiée');

            return $this->redirectToRoute('shiawa_formation_view', array(
                'slug' => $formation->getSlug(),
                'category' => strtolower($formation->getCategory()->getName())
            ));
        }

        return $this->render('ShiawaBlogBundle:Formation:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $formation = $em->getRepository('ShiawaBlogBundle:Formation')->findOneBySlug($slug);

        if (null === $formation) {
            throw new NotFoundHttpException("La formation ".$slug." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($formation);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "La formation a bien été supprimée.");

            return $this->redirectToRoute('shiawa_homepage');
        }

        return $this->render('ShiawaBlogBundle:Formation:delete.html.twig', array(
            'formation' => $formation,
            'form'   => $form->createView(),
        ));
    }

    /**
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function adminListAction()
    {
        $formations = $this->getDoctrine()->getManager()->getRepository('ShiawaBlogBundle:Formation')->findAll();

        return $this->render('ShiawaBlogBundle:Formation:adminList.html.twig', array(
            'formations' => $formations
        ));
    }
}
