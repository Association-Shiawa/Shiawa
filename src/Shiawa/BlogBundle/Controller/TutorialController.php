<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Article;
use Shiawa\BlogBundle\Entity\Formation;
use Shiawa\BlogBundle\Form\ArticleEditType;
use Shiawa\BlogBundle\Form\TutorialType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TutorialController extends Controller
{

    public function viewAction($category, $slug, $formation)
    {
        $em = $this->getDoctrine()
            ->getManager();
        /**
         * @var Article @article
         */
        $article = $em
            ->getRepository('ShiawaBlogBundle:Article')
            ->findOneBySlug($slug);
        $formation = $em
            ->getRepository('ShiawaBlogBundle:Formation')
            ->findOneBySlug($formation);

        $tagsManagement = $this->get('shiawa_blog.tags');
        $linkedContent = $tagsManagement->getLinkedContent($article);

        return $this->render('ShiawaBlogBundle:Tutorial:view.html.twig', array(
            'article' => $article,
            'linkedContent' => $linkedContent,
            'formation' => $formation
        ));
    }

    /**
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request, $chapter, $formation)
    {
        $em = $this->getDoctrine()
            ->getManager();

        /**
         * @var Formation $formation
         */
        $formation = $em->getRepository('ShiawaBlogBundle:Formation')->findOneBySlug($formation);
        $chapter = $em->getRepository('ShiawaBlogBundle:Chapter')->findOneBySlug($chapter);

        $category = $formation->getCategory();

        $article = new Article();
        $article->setCreatedAt(new \Datetime());
        $article->setChapter($chapter);
        $article->setCategory($category);

        $form = $this->createForm(TutorialType::class, $article);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $tagsManagement = $this->get('shiawa_blog.tags');
            $tagsManagement->setArticleTags($article);

            $em->persist($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Article bien enregistré');

            return $this->redirectToRoute('shiawa_tutorial_view', array(
                'slug' => $article->getSlug(),
                'category' => $article->getCategory()->getSlug(),
                'formation' => $formation->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Tutorial:add.html.twig', array(
            'form' => $form->createView(),
            'formation' => $formation,
            'chapter' => $chapter
        ));
    }

    /**
     * @Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction($slug, Request $request)
    {
        $article = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Article')
            ->findOneBySlug($slug);

        if (null === $article) {
            throw new NotFoundHttpException("L'annonce ".$slug." n'existe pas.");
        }

        $form = $this->createForm(ArticleEditType::class, $article);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $tagsManagement = $this->get('shiawa_blog.tags');
            $tagsManagement->setArticleTags($article);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article bien modifié');

            return $this->redirectToRoute('shiawa_article_view', array(
                'slug' => $article->getSlug(),
                'category' => strtolower($article->getCategory()->getName())
            ));
        }

        return $this->render('ShiawaBlogBundle:Article:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ShiawaBlogBundle:Article')->find($slug);

        if (null === $article) {
            throw new NotFoundHttpException("L'article ".$slug." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "L'article a bien été supprimé.");

            return $this->redirectToRoute('shiawa_homepage');
        }

        return $this->render('ShiawaBlogBundle:Article:delete.html.twig', array(
            'article' => $article,
            'form'   => $form->createView(),
        ));
    }
}
