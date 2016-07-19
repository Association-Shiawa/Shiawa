<?php

namespace Shiawa\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Episode
 *
 * @ORM\Table(name="shiawa_episode")
 * @ORM\Entity(repositoryClass="Shiawa\BlogBundle\Repository\EpisodeRepository")
 */
class Episode
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
     * @var int
     *
     * @ORM\Column(name="num_episode", type="integer")
     */
    private $numEpisode;

    /**
     * @var string
     *
     * @ORM\Column(name="embed", type="string", length=255)
     */
    private $embed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Shiawa\BlogBundle\Entity\Anime", inversedBy="episodes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $anime;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
     * @return Episode
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
     * Set numEpisode
     *
     * @param integer $numEpisode
     *
     * @return Episode
     */
    public function setNumEpisode($numEpisode)
    {
        $this->numEpisode = $numEpisode;

        return $this;
    }

    /**
     * Get numEpisode
     *
     * @return int
     */
    public function getNumEpisode()
    {
        return $this->numEpisode;
    }

    /**
     * Set embed
     *
     * @param string $embed
     *
     * @return Episode
     */
    public function setEmbed($embed)
    {
        $this->embed = $embed;

        return $this;
    }

    /**
     * Get embed
     *
     * @return string
     */
    public function getEmbed()
    {
        return $this->embed;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Episode
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
     * Set anime
     *
     * @param \Shiawa\BlogBundle\Entity\Anime $anime
     *
     * @return Episode
     */
    public function setAnime(\Shiawa\BlogBundle\Entity\Anime $anime)
    {
        $this->anime = $anime;

        return $this;
    }

    /**
     * Get anime
     *
     * @return \Shiawa\BlogBundle\Entity\Anime
     */
    public function getAnime()
    {
        return $this->anime;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Episode
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
