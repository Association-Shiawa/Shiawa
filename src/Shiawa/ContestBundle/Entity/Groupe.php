<?php

namespace Shiawa\ContestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupe
 *
 * @ORM\Table(name="groupe")
 * @ORM\Entity(repositoryClass="Shiawa\ContestBundle\Repository\GroupeRepository")
 */
class Groupe
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="soundtrack", type="string", length=255, nullable=true)
     */
    private $soundtrack;

    /**
     * @var string
     *
     * @ORM\Column(name="participateTo", type="string", length=255)
     */
    private $participateTo;

    /**
     * @var string
     *
     * @ORM\Column(name="display", type="string", length=255)
     */
    private $display;

    /**
     * @var bool
     *
     * @ORM\Column(name="accessories", type="boolean", nullable=true)
     */
    private $accessories;

    /**
     * @var string
     *
     * @ORM\Column(name="validated", type="string", length=255, nullable=true)
     */
    private $validated;

    /**
     * @var string
     *
     * @ORM\Column(name="reasons", type="text", nullable=true)
     */
    private $reasons;


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
     * @return Groupe
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
     * Set soundtrack
     *
     * @param string $soundtrack
     *
     * @return Groupe
     */
    public function setSoundtrack($soundtrack)
    {
        $this->soundtrack = $soundtrack;

        return $this;
    }

    /**
     * Get soundtrack
     *
     * @return string
     */
    public function getSoundtrack()
    {
        return $this->soundtrack;
    }

    /**
     * Set participateTo
     *
     * @param string $participateTo
     *
     * @return Groupe
     */
    public function setParticipateTo($participateTo)
    {
        $this->participateTo = $participateTo;

        return $this;
    }

    /**
     * Get participateTo
     *
     * @return string
     */
    public function getParticipateTo()
    {
        return $this->participateTo;
    }

    /**
     * Set display
     *
     * @param string $display
     *
     * @return Groupe
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return string
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set accessories
     *
     * @param boolean $accessories
     *
     * @return Groupe
     */
    public function setAccessories($accessories)
    {
        $this->accessories = $accessories;

        return $this;
    }

    /**
     * Get accessories
     *
     * @return bool
     */
    public function getAccessories()
    {
        return $this->accessories;
    }

    /**
     * Set validated
     *
     * @param string $validated
     *
     * @return Groupe
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return string
     */
    public function getValidated()
    {
        return $this->validated;
    }

    /**
     * Set reasons
     *
     * @param string $reasons
     *
     * @return Groupe
     */
    public function setReasons($reasons)
    {
        $this->reasons = $reasons;

        return $this;
    }

    /**
     * Get reasons
     *
     * @return string
     */
    public function getReasons()
    {
        return $this->reasons;
    }
}

