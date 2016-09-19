<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AnimeController extends Controller {

    public function indexAction(Request $request)
    {
        $category = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Category')
            ->findByName('Anime')
        ;

        $lastAnimeArticles = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Article')
            ->getLastArticles(4, $category)
            ;

        $lastEpisodes = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaBlogBundle:Episode')
            ->getLast(3)
        ;

        return $this->render('AppBundle:Anime:index.html.twig', array(
            'lastAnimeArticles' => $lastAnimeArticles,
            'lastEpisodes' =>$lastEpisodes
        ));
    }

    public function newsAction() {

        //Récupération du repo de anime
        $repositoryAnime = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('ShiawaBlogBundle:Anime');
        //Repo ep
        $repositoryEpisode = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('ShiawaBlogBundle:Episode');
        
        //Repo critiques
        $repositoryCritics = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('ShiawaBlogBundle:AnimeReview');

        //Récup des 5 premiers animes
        $animes = $repositoryAnime->findBy(array(), array('createdAt' => 'desc'), 5);
        $episodes = $repositoryEpisode->findBy(array(), array('createdAt' => 'desc'), 5);
        $critics = $repositoryCritics->findBy(array(), array('createdAt' => 'desc'), 5);

        return $this->render('AppBundle:Anime:news.html.twig', array(
                    "animes" => $animes,
                    "episodes" => $episodes,
                    "reviews" => $critics
        ));
    }

}
