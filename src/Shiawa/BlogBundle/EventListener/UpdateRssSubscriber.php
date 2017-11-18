<?php

namespace Shiawa\BlogBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\ObjectManager;
use Shiawa\BlogBundle\Entity\AnimeReview;
use Shiawa\BlogBundle\Entity\Article;
use Shiawa\EventBundle\Entity\Event;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UpdateRssSubscriber implements EventSubscriber
{

    private $container;
    private $articles;
    private $events;
    private $reviews;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'postUpdate',
        );
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->updateNewsRssFeed($args);
        $this->updatPublicationsRssFeed($args);
        $this->updateEventsRssFeed($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->updateNewsRssFeed($args);
        $this->updatPublicationsRssFeed($args);
        $this->updateEventsRssFeed($args);
    }

    private function updateNewsRssFeed(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Article && !$entity instanceof AnimeReview && !$entity instanceof Event) {
            return;
        }
        $entityManager = $args->getObjectManager();

        $articles = $this->loadArticles($entityManager);
        $events = $this->loadEvents($entityManager);
        $reviews = $this->loadReviews($entityManager);

        $feed = array_merge($articles, $reviews, $events);

        $dumper = $this->container->get('eko_feed.feed.dump');

        $dumper
            ->setRootDir('feed/')
            ->setName('news')
            //You can set an entity
//            ->setEntity(Article::class)
            // Or set you Items
            ->setItems($feed)
            ->setFilename('actualites.rss')
            ->setFormat('rss')
//            ->setLimit('100')
            ->setDirection('DESC')
            ->setOrderBy('id')
        ;

        $dumper->dump();
    }

    private function updatPublicationsRssFeed(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Article && !$entity instanceof AnimeReview) {
            return;
        }
        $entityManager = $args->getObjectManager();

        $articles = $this->loadArticles($entityManager);
        $reviews = $this->loadReviews($entityManager);

        $feed = array_merge($articles, $reviews);

        $dumper = $this->container->get('eko_feed.feed.dump');

        $dumper
            ->setRootDir('feed/')
            ->setName('publications')
            ->setItems($feed)
            ->setFilename('publications.rss')
            ->setFormat('rss')
//            ->setLimit('100')
            ->setDirection('DESC')
            ->setOrderBy('id')
        ;

        $dumper->dump();
    }

    private function updateEventsRssFeed(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Event) {
            return;
        }

        $dumper = $this->container->get('eko_feed.feed.dump');

        $dumper
            ->setRootDir('feed/')
            ->setName('events')
            ->setEntity(Event::class)
            ->setFilename('evenements.rss')
            ->setFormat('rss')
//            ->setLimit('100')
            ->setDirection('DESC')
            ->setOrderBy('id')
        ;

        $dumper->dump();
    }

    private function loadArticles(ObjectManager $entityManager)
    {
        if(!empty($this->articles)) {
            return $this->articles;
        }

        return $this->articles = $entityManager
            ->getRepository('ShiawaBlogBundle:Article')
            ->findBy([], ['id' => 'DESC'], 50);
    }

    private function loadEvents(ObjectManager $entityManager)
    {
        if(!empty($this->events)) {
            return $this->events;
        }

        return $this->events = $entityManager
            ->getRepository('ShiawaEventBundle:Event')
            ->findBy([], ['id' => 'DESC'], 50);
    }

    private function loadReviews(ObjectManager $entityManager)
    {
        if(!empty($this->reviews)) {
            return $this->reviews;
        }

        return $this->reviews = $entityManager
            ->getRepository('ShiawaBlogBundle:AnimeReview')
            ->findBy([], ['id' => 'DESC'], 50);
    }
}