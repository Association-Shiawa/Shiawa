<?php

namespace Shiawa\EventBundle\Controller;

use Shiawa\EventBundle\Entity\Event;
use Shiawa\EventBundle\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class EventController extends Controller
{
    public function indexAction($page)
    {
        if($page < 1) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        $em = $this->getDoctrine()->getManager();
        $eventRep = $em->getRepository('ShiawaEventBundle:Event');

        $nbPerPage = 5;

        $listEvents = $eventRep->getEvents($page, $nbPerPage);
        $nbPage = ceil(count($listEvents)/$nbPerPage);
        if($nbPage == 0) {$nbPage = 1;}

        if($page >  $nbPage && count($listEvents) > 0) {
            throw new NotFoundHttpException('Page "'.$page.'" inexistante');
        }

        return $this->render('ShiawaEventBundle:Event:index.html.twig', array(
            'listEvents' => $listEvents,
            'page' => $page,
            'nbPages' => $nbPage
        ));
    }

    public function viewAction($slug)
    {
        $event = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaEventBundle:Event')
            ->findOneBySlug($slug);

        if($event == null)
        {
            throw new NotFoundHttpException("Il n'existe pas d'évènement de ce nom");
        }

        return $this->render('ShiawaEventBundle:Event:view.html.twig', array(
            'event' => $event
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function addAction(Request $request)
    {
        $event = new Event();
        $event->setBeginAt(new \Datetime());
        $event->setEndAt(new \Datetime());

        $form = $this->createForm(EventType::class, $event);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Evénement bien enregistré');

            return $this->redirectToRoute('shiawa_event_view', array(
                'slug' => $event->getSlug()
            ));
        }

        return $this->render('ShiawaEventBundle:Event:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * //@Security("has_role('ROLE_AUTHOR')")
     */
    public function editAction($slug, Request $request)
    {
        $event = $this->getDoctrine()
            ->getManager()
            ->getRepository('ShiawaEventBundle:Event')
            ->findOneBySlug($slug);

        if (null === $event) {
            throw new NotFoundHttpException("L'événement ".$slug." n'existe pas.");
        }

        $form = $this->createForm(EventType::class, $event);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Evénément bien modifié');

            return $this->redirectToRoute('shiawa_event_view', array(
                'slug' => $event->getSlug()
            ));
        }

        return $this->render('ShiawaEventBundle:Event:edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $event = $em->getRepository('ShiawaEventBundle:Event')->find($slug);

        if (null === $event) {
            throw new NotFoundHttpException("L'événément ".$slug." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->get('form.factory')->create();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($event);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', "L'anime a bien été supprimé.");

            return $this->redirectToRoute('shiawa_admin_homepage');
        }

        return $this->render('ShiawaBlogBundle:Anime:delete.html.twig', array(
            'event' => $event,
            'form'   => $form->createView(),
        ));
    }
}
