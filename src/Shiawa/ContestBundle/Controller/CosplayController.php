<?php

namespace Shiawa\ContestBundle\Controller;

use Shiawa\ContestBundle\Entity\Cosplay;
use Shiawa\ContestBundle\Form\CosplayType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CosplayController extends Controller
{
    public function indexAction()
    {
        return $this->render('ShiawaContestBundle:Cosplay:index.html.twig');
    }

    public function viewAction($slug)
    {
        $cosplay = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaContestBundle:Cosplay')
            ->findOneBySlug($slug);


        return $this->render('ShiawaContestBundle:Cosplay:view.html.twig', array(
            'cosplay' => $cosplay
        ));
    }

    /**
     * //@Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function addAction(Request $request)
    {
        $cosplay = new Cosplay();

        $form = $this->createForm(CosplayType::class, $cosplay);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($cosplay);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Votre Cosplay a bien été enregistré');

            return $this->redirectToRoute('shiawa_contest_view', array(

            ));
        }

        return $this->render('ShiawaContestBundle:Cosplay:add.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
