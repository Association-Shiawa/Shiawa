<?php

namespace Shiawa\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Anime
 *
 * @ORM\Table(name="shiawa_anime")
 * @ORM\Entity(repositoryClass="Shiawa\BlogBundle\Repository\AnimeRepository")
 */
class Anime
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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_new", type="boolean")
     */
    private $isNew;

    /**
     * @var string
     *
     * @ORM\Column(name="synopsis", type="text")
     */
    private $synopsis;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_episode", type="integer")
     */
    private $nbrEpisode;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Shiawa\BlogBundle\Entity\Editor")
     * @ORM\JoinColumn(nullable=true)
     */
    private $editor;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Shiawa\BlogBundle\Entity\Studio")
     * @ORM\JoinColumn(nullable=true)
     */
    private $studio;

    /**
     * @ORM\OneToMany(targetEntity="Shiawa\BlogBundle\Entity\AnimeCharacter", mappedBy="anime")
     */
    private $characters;

    /**
     * @ORM\OneToMany(targetEntity="Shiawa\BlogBundle\Entity\Episode", mappedBy="anime")
     */
    private $episodes;

    /**
     * @ORM\OneToOne(targetEntity="Shiawa\BlogBundle\Entity\AnimeReview", mappedBy="anime")
     */
    private $review;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->characters   = new ArrayCollection();
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
     * @return Anime
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Anime
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
     * Set nbrEpisode
     *
     * @param integer $nbrEpisode
     *
     * @return Anime
     */
    public function setNbrEpisode($nbrEpisode)
    {
        $this->nbrEpisode = $nbrEpisode;

        return $this;
    }

    /**
     * Get nbrEpisode
     *
     * @return int
     */
    public function getNbrEpisode()
    {
        return $this->nbrEpisode;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Anime
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set synopsis
     *
     * @param string $synopsis
     *
     * @return Anime
     */
    public function setSynopsis($synopsis)
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    /**
     * Get synopsis
     *
     * @return string
     */
    public function getSynopsis()
    {
        return $this->synopsis;
    }

    /**
     * Add character
     *
     * @param \Shiawa\BlogBundle\Entity\AnimeCharacter $character
     *
     * @return Anime
     */
    public function addCharacter(\Shiawa\BlogBundle\Entity\AnimeCharacter $character)
    {
        $this->characters[] = $character;

        return $this;
    }

    /**
     * Remove character
     *
     * @param \Shiawa\BlogBundle\Entity\AnimeCharacter $character
     */
    public function removeCharacter(\Shiawa\BlogBundle\Entity\AnimeCharacter $character)
    {
        $this->characters->removeElement($character);
    }

    /**
     * Get characters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * Set editor
     *
     * @param \Shiawa\BlogBundle\Entity\Editor $editor
     *
     * @return Anime
     */
    public function setEditor(\Shiawa\BlogBundle\Entity\Editor $editor)
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * Get editor
     *
     * @return \Shiawa\BlogBundle\Entity\Editor
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * Set studio
     *
     * @param \Shiawa\BlogBundle\Entity\Studio $studio
     *
     * @return Anime
     */
    public function setStudio(\Shiawa\BlogBundle\Entity\Studio $studio)
    {
        $this->studio = $studio;

        return $this;
    }

    /**
     * Get studio
     *
     * @return \Shiawa\BlogBundle\Entity\Studio
     */
    public function getStudio()
    {
        return $this->studio;
    }

    /**
     * Add episode
     *
     * @param \Shiawa\BlogBundle\Entity\Episode $episode
     *
     * @return Anime
     */
    public function addEpisode(\Shiawa\BlogBundle\Entity\Episode $episode)
    {
        $this->episodes[] = $episode;

        return $this;
    }

    /**
     * Remove episode
     *
     * @param \Shiawa\BlogBundle\Entity\Episode $episode
     */
    public function removeEpisode(\Shiawa\BlogBundle\Entity\Episode $episode)
    {
        $this->episodes->removeElement($episode);
    }

    /**
     * Get episodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEpisodes()
    {
        return $this->episodes;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Anime
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
     * Set review
     *
     * @param \Shiawa\BlogBundle\Entity\AnimeReview $review
     *
     * @return Anime
     */
    public function setReview(\Shiawa\BlogBundle\Entity\AnimeReview $review = null)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get review
     *
     * @return \Shiawa\BlogBundle\Entity\AnimeReview
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set isNew
     *
     * @param boolean $isNew
     *
     * @return Anime
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Get isNew
     *
     * @return boolean
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * Set thumbnail
     *
     * @param \Shiawa\FileBundle\Entity\File $thumbnail
     *
     * @return Anime
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
        $dir = "uploads/files/anime/".$this->id."/thumbnail/";
        $this->thumbnail->setUploadDir($dir);

        return $this;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Anime
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
}
