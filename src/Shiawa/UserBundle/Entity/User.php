<?php

namespace Shiawa\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

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
     * @ORM\Column(name="preference", type="string", length=255, nullable=true)
     */
    private $preference;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
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
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
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
}
