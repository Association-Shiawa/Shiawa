<?php

namespace Shiawa\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Chapter
 *
 * @ORM\Table(name="shiawa_chapter")
 * @ORM\Entity(repositoryClass="Shiawa\BlogBundle\Repository\ChapterRepository")
 */
class Chapter
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
     * @ORM\ManyToOne(targetEntity="Shiawa\BlogBundle\Entity\Formation", inversedBy="chapters")
     */
    private $formation;

    /**
     *
     * @ORM\OneToMany(targetEntity="Shiawa\BlogBundle\Entity\Article", mappedBy="chapter")
     */
    private $tutorials;


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
     * @return Chapter
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
     * Constructor
     */
    public function __construct()
    {
        $this->tutorials = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tutorial
     *
     * @param \Shiawa\BlogBundle\Entity\Article $tutorial
     *
     * @return Chapter
     */
    public function addTutorial(\Shiawa\BlogBundle\Entity\Article $tutorial)
    {
        $this->tutorials[] = $tutorial;

        return $this;
    }

    /**
     * Remove tutorial
     *
     * @param \Shiawa\BlogBundle\Entity\Article $tutorial
     */
    public function removeTutorial(\Shiawa\BlogBundle\Entity\Article $tutorial)
    {
        $this->tutorials->removeElement($tutorial);
    }

    /**
     * Get tutorials
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTutorials()
    {
        return $this->tutorials;
    }

    /**
     * Set formation
     *
     * @param \Shiawa\BlogBundle\Entity\Formation $formation
     *
     * @return Chapter
     */
    public function setFormation(\Shiawa\BlogBundle\Entity\Formation $formation = null)
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * Get formation
     *
     * @return \Shiawa\BlogBundle\Entity\Formation
     */
    public function getFormation()
    {
        return $this->formation;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Chapter
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
}
