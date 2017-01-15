<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    public function indexAction()
    {

        return $this->render('AppBundle:Admin:index.html.twig', array(
        ));
    }

    public function cacheClearAction(Request $request)
    {
        $kernel = $this->get('kernel');
        $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $application->setAutoExit(false);
        $options = array('command' => 'cache:clear',"--env" => 'prod', '--no-warmup' => true);
        $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
        return $this->redirectToRoute('shiawa_admin_homepage');
    }

    public function testAction(){
        $youtubeService = $this->get('shiawa_blog.youtube');
        $youtubeService->getLastVideos();
        return new Response();
    }
}
