<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Article;
use Shiawa\BlogBundle\Entity\Formation;
use Shiawa\BlogBundle\Form\ArticleEditType;
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
}
