<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Article;
use Shiawa\BlogBundle\Form\ArticleEditType;
use Shiawa\BlogBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ArticleController extends Controller
{
    public function indexAction($page, $category)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $categoryName = $category;

        $category = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Category')
            ->findByName($categoryName)
        ;

        $em = $this->getDoctrine()->getManager();
        $artRep = $em->getRepository('ShiawaBlogBundle:Article');

        $nbPerPage = 5;

        $listArticles = $artRep->getArticles($page, $nbPerPage, $category);
        $nbPage = ceil(count($listArticles)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listArticles) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:Article:index.html.twig', array(
            'listArticles' => $listArticles,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction($category, $slug)
    {
        $article = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Article')
            ->findOneBySlug($slug);

        $tagList = array();

        for($j = 0; $j < count($article->getTags()); $j++) {
            array_push($tagList, $article->getTags()[$j]->getId());
        }

        $linkedContent = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Article')
            ->findByTags($tagList, 2, $article->getId());


        return $this->render('ShiawaBlogBundle:Article:view.html.twig', array(
            'article' => $article,
            'linkedContent' => $linkedContent
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $article = new Article();
        $article->setCreatedAt(new \Datetime());

        $form = $this->createForm(ArticleType::class, $article);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $tagRep = $this->getDoctrine()
                ->getManager()
                ->getRepository('ShiawaBlogBundle:Tag');


            for($i=0; $i < count($article->getTags()); $i++) {
                $tag = $article->getTags()[$i];

                $article->getTags()[$i]->setName(strtolower($tag->getName()));
                $tagDb = $tagRep->findOneByName($tag->getName());

                if($tagDb == null){

                }else{
                    $article->getTags()[$i] = $tagDb;
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article bien enregistré');

            return $this->redirectToRoute('shiawa_article_view', array(
                'slug' => $article->getSlug(),
                'category' => strtolower($article->getCategory()->getName())
            ));
        }

        return $this->render('ShiawaBlogBundle:Article:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
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
            $tagRep = $this->getDoctrine()
                ->getManager()
                ->getRepository('ShiawaBlogBundle:Tag');


            for($i=0; $i < count($article->getTags()); $i++) {
                $tag = $article->getTags()[$i];

                $article->getTags()[$i]->setName(strtolower($tag->getName()));
                $tagDb = $tagRep->findOneByName($tag->getName());

                if($tagDb == null){

                }else{
                    $article->getTags()[$i] = $tagDb;
                }
            }

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
            throw new NotFoundHttpException("L'annonce ".$slug." n'existe pas.");
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

        return $this->render('OCPlatformBundle:Advert:delete.html.twig', array(
            'article' => $article,
            'form'   => $form->createView(),
        ));
    }
}
