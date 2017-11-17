<?php

namespace Shiawa\BlogBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use  Eko\FeedBundle\Service\FeedDumpService;
use Shiawa\BlogBundle\Entity\Article;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ArticleRssSubscriber implements EventSubscriber
{

    private $container;

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
        $this->updateRssFeed($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->updateRssFeed($args);
    }

    private function updateRssFeed(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Article) {
            return;
        }
        $entityManager = $args->getObjectManager();
        /** @var Article $entity */
//        $articles = $entityManager
//            ->getRepository('ShiawaBlogBundle:Article')
//            ->findAll()
//        ;

        $dumper = $this->container->get('eko_feed.feed.dump');

        $dumper
            ->setRootDir('feed/')
            ->setName('article')
            //You can set an entity
            ->setEntity(Article::class)
            // Or set you Items
//            ->setItems($articles)
            ->setFilename('articles.rss')
            ->setFormat('rss')
//            ->setLimit('100')
            ->setDirection('DESC')
            ->setOrderBy('id')
        ;

        $dumper->dump();
    }
}