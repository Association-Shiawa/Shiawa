<?php

namespace Shiawa\BlogBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class DoctrineFilterListener
{

    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if ('easyadmin' === $event->getRequest()->attributes->get('_route')) {
            return;
        }

        $filter = $this->em->getFilters()->enable('published_filter');
        $filter->setParameter('published', true);

        $filter = $this->em->getFilters()->enable('post_dated_filter');
    }
}