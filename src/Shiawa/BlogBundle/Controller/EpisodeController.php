<?php

namespace Shiawa\BlogBundle\Controller;

use Shiawa\BlogBundle\Entity\Episode;
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
