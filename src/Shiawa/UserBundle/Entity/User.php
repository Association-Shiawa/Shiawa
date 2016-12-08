<?php

namespace Shiawa\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="shiawa_user")
 * @ORM\Entity(repositoryClass="Shiawa\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @var \DateTime
     *
     * @Assert\LessThan("-10 years")
     * @ORM\Column(name="birthdate", type="date", nullable=true)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="preference", type="string", length=255, nullable=true)
     */
    private $preference;

    /**
     * @var File
     *
     * @ORM\ManyToOne(targetEntity="Shiawa\FileBundle\Entity\File", cascade={"remove", "persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="mal_account", type="string", length=255, nullable=true)
     */
    private $malAccount;

    /**
     * @var bool
     *
     * @ORM\Column(name="notification", type="boolean")
     */
    private $notification = false;


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
     * Set preference
     *
     * @param string $preference
     *
     * @return User
     */
    public function setPreference($preference)
    {
        $this->preference = $preference;

        return $this;
    }

    /**
     * Get preference
     *
     * @return string
     */
    public function getPreference()
    {
        return $this->preference;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return User
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
     * Set malAccount
     *
     * @param string $malAccount
     *
     * @return User
     */
    public function setMalAccount($malAccount)
    {
        $this->malAccount = $malAccount;

        return $this;
    }

    /**
     * Get malAccount
     *
     * @return string
     */
    public function getMalAccount()
    {
        return $this->malAccount;
    }

    /**
     * Set notification
     *
     * @param boolean $notification
     *
     * @return User
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * Get notification
     *
     * @return boolean
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set surname
     *
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set birthdate
     *
     * @param \DateTime $birthdate
     *
     * @return User
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return \DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set image
     *
     * @param \Shiawa\FileBundle\Entity\File $image
     *
     * @return User
     */
    public function setAvatar(\Shiawa\FileBundle\Entity\File $image)
    {
        $this->avatar = $image;
        $this->setImageDir();

        return $this;
    }

    public function setAvatarDir()
    {
        $dir = "uploads/files/users/".$this->usernameCanonical."/avatar/";
        $this->avatar->setUploadDir($dir);

        return $this;
    }

    /**
     * Get image
     *
     * @return \Shiawa\FileBundle\Entity\File
     */
    public function getAvatar()
    {
        if ($this->avatar != null) {
            $this->setAvatarDir();
        }
        return $this->avatar;
    }
}
