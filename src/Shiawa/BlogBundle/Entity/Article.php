<?php

namespace Shiawa\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Shiawa\UserBundle as User;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Article
 *
 * @ORM\Table(name="shiawa_article")
 * @ORM\Entity(repositoryClass="Shiawa\BlogBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToOne(targetEntity="Shiawa\FileBundle\Entity\File", cascade={"persist", "remove"})
     */
    private $thumbnail;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text")
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Shiawa\BlogBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Shiawa\BlogBundle\Entity\Tag", cascade={"persist"})
     * @ORM\JoinTable(name="shiawa_article_tag")
     */
    private $tags;

    /**
     * @var User $author
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Shiawa\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @var Event $event
     *
     * @ORM\ManyToOne(targetEntity="Shiawa\EventBundle\Entity\Event", inversedBy="articles")
     * @ORM\JoinColumn(nullable=true)
     */
    private $event;



    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->tags   = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return Article
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Article
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Article
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Article
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Article
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set viewed
     *
     * @param integer $viewed
     *
     * @return Article
     */
    public function setViewed($viewed)
    {
        $this->viewed = $viewed;

        return $this;
    }

    /**
     * Get viewed
     *
     * @return integer
     */
    public function getViewed()
    {
        return $this->viewed;
    }

    /**
     * Set category
     *
     * @param \Shiawa\BlogBundle\Entity\Category $category
     *
     * @return Article
     */
    public function setCategory(\Shiawa\BlogBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Shiawa\BlogBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add tag
     *
     * @param \Shiawa\BlogBundle\Entity\Tag $tag
     *
     * @return Article
     */
    public function addTag(\Shiawa\BlogBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Shiawa\BlogBundle\Entity\Tag $tag
     */
    public function removeTag(\Shiawa\BlogBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set author
     *
     * @param \Shiawa\UserBundle\Entity\User $author
     *
     * @return Article
     */
    public function setAuthor(\Shiawa\UserBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Shiawa\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set event
     *
     * @param \Shiawa\EventBundle\Entity\Event $event
     *
     * @return Article
     */
    public function setEvent(\Shiawa\EventBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Shiawa\EventBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set thumbnail
     *
     * @param \Shiawa\FileBundle\Entity\File $thumbnail
     *
     * @return Article
     */
    public function setThumbnail(\Shiawa\FileBundle\Entity\File $thumbnail = null)
    {
        $this->thumbnail = $thumbnail;
        $this->setThumbnailDir();

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return \Shiawa\FileBundle\Entity\File
     */
    public function getThumbnail()
    {
        if ($this->thumbnail != null) {
            $this->setThumbnailDir();
        }
        return $this->thumbnail;
    }

    public function setThumbnailDir()
    {
        $dir = "uploads/files/articles/".$this->id."/thumbnail/";
        $this->thumbnail->setUploadDir($dir);

        return $this;
    }
}
