<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Episode;
use Shiawa\BlogBundle\Form\EpisodeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class EpisodeController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getManager();
        $episodeRep = $em->getRepository('ShiawaBlogBundle:Episode');

        $nbPerPage = 5;

        $listEp = $episodeRep->getEpisodes($page, $nbPerPage);
        $nbPage = ceil(count($listEp)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listEp) > 0) {
            return new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaBlogBundle:Episode:index.html.twig', array(
            'listEpisodes' => $listEp,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction($slug)
    {
        $episode = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Episode')
            ->findOneBySlug($slug);


        return $this->render('ShiawaBlogBundle:Episode:view.html.twig', array(
            'episode' => $episode
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $episode = new Episode();
        $episode->setCreatedAt(new \Datetime());

        $form = $this->createForm(EpisodeType::class, $episode);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($episode);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Episode bien enregistré');

            return $this->redirectToRoute('shiawa_episode_view', array(
                'slug' => $episode->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Episode:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction($slug, Request $request)
    {
        $episode = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Episode')
            ->findOneBySlug($slug);

        if (null === $episode) {
            throw new NotFoundHttpException("L'épisode ".$slug." n'existe pas.");
        }

        $form = $this->createForm(EpisodeType::class, $episode);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($episode);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Episode bien modifié');

            return $this->redirectToRoute('shiawa_episode_view', array(
                'slug' => $episode->getSlug()
            ));
        }

        return $this->render('ShiawaBlogBundle:Episode:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $episode = $em->getRepository('ShiawaBlogBundle:Episode')->find($slug);

        if (null === $episode) {
            throw new NotFoundHttpException("L'épisode ".$slug." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($episode);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "L'épisode a bien été supprimé.");

            return $this->redirectToRoute('shiawa_homepage');
        }

        return $this->render('ShiawaBlogBundle:Episode:delete.html.twig', array(
            'episode' => $episode,
            'form'   => $form->createView(),
        ));
    }

    public function ajaxListAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $episode = $request->request->get('anime');

            $em = $this->getDoctrine()->getManager();
            $episodeRep = $em->getRepository('ShiawaBlogBundle:Episode');
            $episodeList = $episodeRep->getArrayEpisode($episode);


            $encoder = new JsonEncoder();
            $normalizer = new ObjectNormalizer();

            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getTitle();
            });

            $serializer = new Serializer(array($normalizer), array($encoder));

            $data = $serializer->serialize($episodeList, 'json');
            //$data = json_encode($episodeList);
            return new JsonResponse($data, 200);
        }else{
            return new Response('et BIM ça plante');
        }

    }
}
