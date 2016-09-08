<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\AnimeReview;
use Shiawa\BlogBundle\Form\AnimeReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AnimeReviewController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getManager();
        $reviewRep = $em->getRepository('ShiawaBlogBundle:AnimeReview');

        $nbPerPage = 3;

        $listReview = $reviewRep->getReview($page, $nbPerPage);
        $nbPage = ceil(count($listReview)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listReview) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:AnimeReview:index.html.twig', array(
            'listAnimeReview' => $listReview,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction($slug)
    {
        $review = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:AnimeReview')
            ->findOneBySlug($slug);


        return $this->render('ShiawaBlogBundle:AnimeReview:view.html.twig', array(
            'review' => $review
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $review = new AnimeReview();
        $review->setCreatedAt(new \Datetime());

        $form = $this->createForm(AnimeReviewType::class, $review);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $tagsManagement = $this->get('shiawa_blog.tags');
            $tagsManagement->setArticleTags($review);

            $animeTitle = $form->get("anime")->getData();
            $anime = $this->getDoctrine()->getManager()->getRepository('ShiawaBlogBundle:Anime')->findOneBy(array
            ('title' =>
                $animeTitle));

            $review->setAnime($anime);

            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Article bien enregistré');

            return $this->redirectToRoute('shiawa_anime_review_view', array(
                'slug' => $review->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:AnimeReview:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction($slug, Request $request)
    {
        $review = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:AnimeReview')
            ->findOneBySlug($slug);

        if (null === $review) {
            throw new NotFoundHttpException("La critique Anime ".$slug." n'existe pas.");
        }

        $form = $this->createForm(AnimeReviewType::class, $review);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $tagRep = $this->getDoctrine()
                ->getManager()
                ->getRepository('ShiawaBlogBundle:Tag');


            for($i=0; $i < count($review->getTags()); $i++) {
                $tag = $review->getTags()[$i];

                $review->getTags()[$i]->setName(strtolower($tag->getName()));
                $tagDb = $tagRep->findOneByName($tag->getName());

                if($tagDb == null){

                }else{
                    $review->getTags()[$i] = $tagDb;
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Critique Anime bien modifiée');

            return $this->redirectToRoute('shiawa_anime_review_view', array(
                'slug' => $review->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:AnimeReview:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($slug)
    {

    }
}