<?php

namespace Shiawa\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AnimeCharacter
 *
 * @ORM\Table(name="shiawa_anime_character")
 * @ORM\Entity(repositoryClass="Shiawa\BlogBundle\Repository\AnimeCharacterRepository")
 */
class AnimeCharacter
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255)
     */
    private $avatar;

    /**
     * @var file
     *
     * @ORM\ManyToOne(targetEntity="Shiawa\FileBundle\Entity\File")
     * @ORM\JoinColumn(nullable=false)
     */
    //private $image;

    /**
     * @ORM\ManyToOne(targetEntity="Shiawa\BlogBundle\Entity\Anime", inversedBy="characters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $anime;


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
     * Set name
     *
     * @param string $name
     *
     * @return AnimeCharacter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return AnimeCharacter
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set anime
     *
     * @param \Shiawa\BlogBundle\Entity\Anime $anime
     *
     * @return AnimeCharacter
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
     * @return AnimeCharacter
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
