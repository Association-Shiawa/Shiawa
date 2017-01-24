<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Category;
use Shiawa\BlogBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CategoryController extends Controller
{
    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function indexAction($page)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getManager();
        $catRep = $em->getRepository('ShiawaBlogBundle:Category');

        $nbPerPage = 10;

        $listCat = $catRep->getCategories($page, $nbPerPage);
        $nbPage = ceil(count($listCat)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listCat) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:Category:index.html.twig', array(
            'listCat' => $listCat,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function viewAction($slug)
    {
        $cat = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Category')
            ->findOneBySlug($slug);


        return $this->render('ShiawaBlogBundle:Category:view.html.twig', array(
            'category' => $cat
        ));
    }

    /**
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $cat = new Category();

        $form = $this->createForm(CategoryType::class, $cat);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Categorie bien enregistrée');

            return $this->redirectToRoute('shiawa_category_view', array(
                'slug' => $cat->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Category:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction($slug, Request $request)
    {
        $cat = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Category')
            ->findOneBySlug($slug);

        if (null === $cat) {
            throw new NotFoundHttpException("La catégorie ".$slug." n'existe pas.");
        }

        $form = $this->createForm(CategoryType::class, $cat);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Catégorie bien modifiée');

            return $this->redirectToRoute('shiawa_category_view', array(
                'slug' => $cat->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Category:edit.html.twig', array(
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
