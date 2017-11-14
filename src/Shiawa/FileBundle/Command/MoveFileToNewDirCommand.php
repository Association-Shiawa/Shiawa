<?php

namespace Shiawa\FileBundle\Command;

use Doctrine\ORM\EntityManager;
use Shiawa\BlogBundle\Entity\Anime;
use Shiawa\BlogBundle\Entity\AnimeReview;
use Shiawa\BlogBundle\Entity\Article;
use Shiawa\EventBundle\Entity\Event;
use Shiawa\FileBundle\Entity\BlogFile;
use Shiawa\FileBundle\Entity\ProfilePicture;
use Shiawa\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;

class MoveFileToNewDirCommand extends ContainerAwareCommand
{
    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('app:move-files')

            // the short description shown while running "php bin/console list"
            ->setDescription('Move files to new directory structure')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Move files to new directory structure')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //récupérer les images des articles, anime, animereview, event, users

        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        $finder = new Finder();
        $finder->files()->in(__DIR__.'/../../../../web/uploads');

        foreach ($finder as $file) {
            $relPath = $file->getRelativePath();
            $relPathname = $file->getRelativePathname();
            $realPath = $file->getRealPath();

//            $file = new UploadedFile($realPath, $file->getFilename());

            $output->writeln($realPath);
            $output->writeln($relPathname);

            $file = new File($file->getRealPath());
//            $output->writeln($file->getMimeType());
            $this->moveArticlesMedia($file, $output, $em);
            $this->moveEventsMedia($file, $output, $em);
            $this->moveUsersMedia($file, $output, $em);
            $this->moveAnimeAndReviewMedia($file, $output, $em);
        }
        $em->flush();
    }

    private function moveArticlesMedia(File $file, OutputInterface $output, EntityManager $em) {
        $path = $file->getPath();

        $pattern = '/(articles\\\\)(\d+)+/';
        if (preg_match($pattern, $path, $findMedia)) {
            $output->writeln($path.' a matché !');
            $id = $findMedia[2];
            $output->writeln('This image is from the article of ID => '.$id);
            /** @var Article $article */
            $article = $em->find(Article::class, $id);
            if($article) {
                $output->writeln('Article Title : '.$article->getTitle());
                $blogFile = new BlogFile();
                $blogFile = $this->setFileInfo($file, $blogFile, $article->getThumbnail());
                $article->setThumbnail($blogFile);
                $this->moveFile($blogFile);
                $em->persist($article);
            }
        }
    }

    private function moveEventsMedia(File $file, OutputInterface $output, EntityManager $em) {
        $path = $file->getPath();

        $pattern = '/(event\\\\)(\d+)+/';
        if (preg_match($pattern, $path, $findMedia)) {
            $id = $findMedia[2];
            $output->writeln('This image is from the event of ID => '.$id);
            /** @var Event $event */
            $event = $em->find(Event::class, $id);
            if($event) {
                $output->writeln('Event Title : '.$event->getName());
                $blogFile = new BlogFile();
                $blogFile = $this->setFileInfo($file, $blogFile, $event->getThumbnail());
                $event->setThumbnail($blogFile);
                $this->moveFile($blogFile);
                $em->persist($event);
            }
        }
    }

    private function moveUsersMedia(File $file, OutputInterface $output, EntityManager $em) {
        $path = $file->getPath();

        $pattern = '/(users\\\\)(\w+)+/';
        if (preg_match($pattern, $path, $findMedia)) {
            $username = $findMedia[2];
            $output->writeln('This image is from the user of ID => '.$username);
            /** @var User $user */
            $user = $em->getRepository(User::class)->findOneByUsername($username);
            if($user) {
                $output->writeln('User Title : '.$user->getUsername());
                $avatar = new ProfilePicture();
                $avatar = $this->setFileInfo($file, $avatar, $user->getAvatar());
                $user->setAvatar($avatar);
                $this->moveFile($avatar);
                $em->persist($user);
            }
        }
    }

    private function moveAnimeAndReviewMedia(File $file, OutputInterface $output, EntityManager $em) {
        $path = $file->getPath();

        $blogFile = new BlogFile();

        $animePattern = '/(anime\\\\)(\d+)+/';
        $reviewPattern = '/(review\\\\)(\d+)+/';
        if (preg_match($animePattern, $path, $findAnimeMedia)) {
            if (preg_match($reviewPattern, $path, $findReviewMedia)) {
                $id = $findReviewMedia[2];
                $output->writeln('This image is from the review of ID => '.$id);
                /** @var AnimeReview $review */
                $review = $em->find(AnimeReview::class, $id);
                if($review) {
                    $output->writeln('Review Title : '.$review->getTitle());
                    $blogFile = $this->setFileInfo($file, $blogFile, $review->getThumbnail());
                    $review->setThumbnail($blogFile);
                    $this->moveFile($blogFile);
                    $em->persist($review);
                }
            } else {
                $id = $findAnimeMedia[2];
                $output->writeln('This image is from the anime of ID => '.$id);
                /** @var Anime $anime */
                $anime = $em->find(Anime::class, $id);
                if($anime) {
                    $output->writeln('Review Title : '.$anime->getTitle());
                    $anime->setThumbnail($blogFile);
                    $this->moveFile($blogFile);
                    $em->persist($anime);
                }
            }
        }
    }

    private function moveFile(\Shiawa\FileBundle\Entity\File $file)
    {
        $filename = $file->getFilename();
        $first = substr($filename, 0, 1);
        $second = substr($filename, 1, 1);
        if($file instanceof BlogFile) {
            $path = $this->getContainer()->getParameter('app.fullpath.blog_file');
            $path .= $path.'/'.$first.'/'.$second;
        }else {
            $path = $this->getContainer()->getParameter('app.fullpath.user_pic');
        }

        $file->getFile()->move($path, $filename);
    }

    private function setFileInfo(File $file, \Shiawa\FileBundle\Entity\File $object, \Shiawa\FileBundle\Entity\File $oldFile) {
        $author = $oldFile->getAuthor();
        $object->setFile($file);
        $object->setFilename($file->getFilename());
        $object->setAuthor($author);
        return $object;
    }
}