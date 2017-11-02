<?php

namespace Shiawa\BlogBundle\EventListener\EasyAdmin;

use Shiawa\BlogBundle\Entity\Article;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class TagsSubscriber implements EventSubscriberInterface
{
    private $slugger;

    public function __construct()
    {
    }

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.pre_persist' => array('createTags'),
        );
    }

    public function createTags(GenericEvent $event)
    {
        $entity = $event->getSubject();

        if (!($entity instanceof Article)) {
            return;
        }

        dump($event);die();

        $slug = $this->slugger->slugify($entity->getTitle());
        $entity->setSlug($slug);

        $event['entity'] = $entity;
    }
}