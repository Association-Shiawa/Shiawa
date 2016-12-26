<?php

namespace Shiawa\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Shiawa\UserBundle as User;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AnimeReview
 *
 * @ORM\Table(name="shiawa_anime_review")
 * @ORM\Entity(repositoryClass="Shiawa\BlogBundle\Repository\AnimeReviewRepository")
 */
class AnimeReview
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
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var User $author
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="Shiawa\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

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
     * @ORM\Column(name="introduction", type="text")
     */
    private $introduction;

    /**
     * @var string
     *
     * @ORM\Column(name="critic_scenario", type="text")
     */
    private $criticScenario;

    /**
     * @var string
     *
     * @ORM\Column(name="critic_graphisms", type="text")
     */
    private $criticGraphisms;

    /**
     * @var string
     *
     * @ORM\Column(name="critic_soundtrack", type="text")
     */
    private $criticSoundtrack;

    /**
     * @var string
     *
     * @ORM\Column(name="critic_consistency", type="text")
     */
    private $criticConsistency;

    /**
     *
     * @ORM\Column(name="note_scenario", type="integer")
     */
    private $noteScenario;

    /**
     *
     * @ORM\Column(name="note_graphism", type="integer")
     */
    private $noteGraphism;

    /**
     *
     * @ORM\Column(name="note_soundtrack", type="integer")
     */
    private $noteSoundtrack;

    /**
     *
     * @ORM\Column(name="note_characters", type="integer")
     */
    private $noteCharacters;

    /**
     *
     * @ORM\Column(name="note_consistency", type="integer")
     */
    private $noteConsistency;

    /**
     * @var string
     *
     * @ORM\Column(name="conclusion", type="text")
     */
    private $conclusion;

    /**
     * @ORM\OneToOne(targetEntity="Shiawa\BlogBundle\Entity\Anime", cascade={"persist"}, inversedBy="review")
     * @ORM\JoinColumn(nullable=false)
     */
    private $anime;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Shiawa\BlogBundle\Entity\Tag", cascade={"persist"})
     * @ORM\JoinTable(name="shiawa_anime_review_tag")
     */
    private $tags;

    /**
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = true;


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
     * @return AnimeReview
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
     * @return AnimeReview
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
     * @return AnimeReview
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
     * @return AnimeReview
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
     * Set image
     *
     * @param string $image
     *
     * @return AnimeReview
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
     * Set introduction
     *
     * @param string $introduction
     *
     * @return AnimeReview
     */
    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * Get introduction
     *
     * @return string
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * Set criticScenario
     *
     * @param string $criticScenario
     *
     * @return AnimeReview
     */
    public function setCriticScenario($criticScenario)
    {
        $this->criticScenario = $criticScenario;

        return $this;
    }

    /**
     * Get criticScenario
     *
     * @return string
     */
    public function getCriticScenario()
    {
        return $this->criticScenario;
    }

    /**
     * Set criticGraphisms
     *
     * @param string $criticGraphisms
     *
     * @return AnimeReview
     */
    public function setCriticGraphisms($criticGraphisms)
    {
        $this->criticGraphisms = $criticGraphisms;

        return $this;
    }

    /**
     * Get criticGraphisms
     *
     * @return string
     */
    public function getCriticGraphisms()
    {
        return $this->criticGraphisms;
    }

    /**
     * Set criticSoundtrack
     *
     * @param string $criticSoundtrack
     *
     * @return AnimeReview
     */
    public function setCriticSoundtrack($criticSoundtrack)
    {
        $this->criticSoundtrack = $criticSoundtrack;

        return $this;
    }

    /**
     * Get criticSoundtrack
     *
     * @return string
     */
    public function getCriticSoundtrack()
    {
        return $this->criticSoundtrack;
    }

    /**
     * Set criticConsistency
     *
     * @param string $criticConsistency
     *
     * @return AnimeReview
     */
    public function setCriticConsistency($criticConsistency)
    {
        $this->criticConsistency = $criticConsistency;

        return $this;
    }

    /**
     * Get criticConsistency
     *
     * @return string
     */
    public function getCriticConsistency()
    {
        return $this->criticConsistency;
    }

    /**
     * Set noteScenario
     *
     * @param integer $noteScenario
     *
     * @return AnimeReview
     */
    public function setNoteScenario($noteScenario)
    {
        $this->noteScenario = $noteScenario;

        return $this;
    }

    /**
     * Get noteScenario
     *
     * @return integer
     */
    public function getNoteScenario()
    {
        return $this->noteScenario;
    }

    /**
     * Set noteGraphism
     *
     * @param integer $noteGraphism
     *
     * @return AnimeReview
     */
    public function setNoteGraphism($noteGraphism)
    {
        $this->noteGraphism = $noteGraphism;

        return $this;
    }

    /**
     * Get noteGraphism
     *
     * @return integer
     */
    public function getNoteGraphism()
    {
        return $this->noteGraphism;
    }

    /**
     * Set noteSoundtrack
     *
     * @param integer $noteSoundtrack
     *
     * @return AnimeReview
     */
    public function setNoteSoundtrack($noteSoundtrack)
    {
        $this->noteSoundtrack = $noteSoundtrack;

        return $this;
    }

    /**
     * Get noteSoundtrack
     *
     * @return integer
     */
    public function getNoteSoundtrack()
    {
        return $this->noteSoundtrack;
    }

    /**
     * Set noteCharacters
     *
     * @param integer $noteCharacters
     *
     * @return AnimeReview
     */
    public function setNoteCharacters($noteCharacters)
    {
        $this->noteCharacters = $noteCharacters;

        return $this;
    }

    /**
     * Get noteCharacters
     *
     * @return integer
     */
    public function getNoteCharacters()
    {
        return $this->noteCharacters;
    }

    /**
     * Set noteConsistency
     *
     * @param integer $noteConsistency
     *
     * @return AnimeReview
     */
    public function setNoteConsistency($noteConsistency)
    {
        $this->noteConsistency = $noteConsistency;

        return $this;
    }

    /**
     * Get noteConsistency
     *
     * @return integer
     */
    public function getNoteConsistency()
    {
        return $this->noteConsistency;
    }

    /**
     * Set conclusion
     *
     * @param string $conclusion
     *
     * @return AnimeReview
     */
    public function setConclusion($conclusion)
    {
        $this->conclusion = $conclusion;

        return $this;
    }

    /**
     * Get conclusion
     *
     * @return string
     */
    public function getConclusion()
    {
        return $this->conclusion;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return AnimeReview
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
     * Add tag
     *
     * @param \Shiawa\BlogBundle\Entity\Tag $tag
     *
     * @return AnimeReview
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
     * @return AnimeReview
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
     * Set anime
     *
     * @param \Shiawa\BlogBundle\Entity\Anime $anime
     *
     * @return AnimeReview
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
     * Set thumbnail
     *
     * @param \Shiawa\FileBundle\Entity\File $thumbnail
     *
     * @return AnimeReview
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
        $dir = "uploads/files/anime/".$this->getAnime()->getId()."/review/".$this->id."/thumbnail/";
        $this->thumbnail->setUploadDir($dir);

        return $this;
    }
}
