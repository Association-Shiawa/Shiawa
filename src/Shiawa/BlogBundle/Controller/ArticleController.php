<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Article;
use Shiawa\BlogBundle\Entity\ArticleSearch;
use Shiawa\BlogBundle\Form\ArticleSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ArticleController extends Controller
{
    public function indexAction($page, Request $request)
    {
       if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
       }

        $em = $this->getDoctrine()->getManager();
        $artRep = $em->getRepository('ShiawaBlogBundle:Article');

        $nbPerPage = 9;

        $articleSearch = new ArticleSearch();
        $searchForm = $this->createForm(ArticleSearchType::class, $articleSearch);

        $searchForm->handleRequest($request);

        $result = $request->query->all();

        $listArticles = $artRep->getArticles($page, $nbPerPage, $result);
        $nbPage = ceil(count($listArticles)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listArticles) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:Article:index.html.twig', array(
            'listArticles' => $listArticles,
            'page' => $page,
            'nbPages' => $nbPage,
            'searchform' => $searchForm->createView()
        ));
    }

    public function viewAction($category, $slug)
    {
        /**
         * @var Article $article
         */
        $article = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Article')
            ->findOneBySlug($slug);

        if ($article->getChapter() != null)
        {
            return $this->redirectToRoute('shiawa_tutorial_view', array(
                'slug' => $article->getSlug(),
                'category' => $article->getCategory()->getSlug(),
                'formation' => $article->getChapter()->getFormation()->getSlug()
            ));
        }


        $tagsManagement = $this->get('shiawa_blog.tags');
        $linkedContent = $tagsManagement->getLinkedContent($article);

        return $this->render('ShiawaBlogBundle:Article:view.html.twig', array(
            'article' => $article,
            'linkedContent' => $linkedContent
        ));
    }
}
