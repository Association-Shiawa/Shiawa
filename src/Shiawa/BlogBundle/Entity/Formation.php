<?php

namespace Shiawa\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Shiawa\FileBundle\Entity\File;
use Shiawa\UserBundle\Entity\User as User;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Formation
 *
 * @ORM\Table(name="shiawa_courses")
 * @ORM\Entity(repositoryClass="Shiawa\BlogBundle\Repository\FormationRepository")
 */
class Formation
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
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToOne(targetEntity="Shiawa\FileBundle\Entity\BlogFile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $thumbnail;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     *
     * @ORM\OneToMany(targetEntity="Shiawa\BlogBundle\Entity\Chapter", cascade={"persist", "remove"}, mappedBy="formation")
     * @ORM\JoinTable(name="shiawa_formation_chapter")
     */
    private $chapters;

    /**
     * @var User $author
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Shiawa\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Shiawa\BlogBundle\Entity\Tag", cascade={"persist"})
     * @ORM\JoinTable(name="shiawa_courses_tag")
     */
    private $tags;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Shiawa\BlogBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->tags   = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
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
     * @return Formation
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
     * @return Formation
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Formation
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
     * Set description
     *
     * @param string $description
     *
     * @return Formation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add chapter
     *
     * @param \Shiawa\BlogBundle\Entity\Chapter $chapter
     *
     * @return Formation
     */
    public function addChapter(\Shiawa\BlogBundle\Entity\Chapter $chapter)
    {
        $chapter->setFormation($this);
        $this->chapters[] = $chapter;

        return $this;
    }

    /**
     * Remove chapter
     *
     * @param \Shiawa\BlogBundle\Entity\Chapter $chapter
     */
    public function removeChapter(\Shiawa\BlogBundle\Entity\Chapter $chapter)
    {
        $this->chapters->removeElement($chapter);
    }

    /**
     * Get chapters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChapters()
    {
        return $this->chapters;
    }

    /**
     * Set author
     *
     * @param \Shiawa\UserBundle\Entity\User $author
     *
     * @return Formation
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
     * Add tag
     *
     * @param \Shiawa\BlogBundle\Entity\Tag $tag
     *
     * @return Formation
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
     * Set category
     *
     * @param \Shiawa\BlogBundle\Entity\Category $category
     *
     * @return Formation
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
     * Set thumbnail
     *
     * @param \Shiawa\FileBundle\Entity\File $thumbnail
     *
     * @return File|void
     */
    public function setThumbnail(\Shiawa\FileBundle\Entity\File $thumbnail = null)
    {
        if (empty($thumbnail->getFile())) {
            return;
        }

        $this->thumbnail = $thumbnail;
    }

    /**
     * Get thumbnail
     *
     * @return \Shiawa\FileBundle\Entity\File
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
}
