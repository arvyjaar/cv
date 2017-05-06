<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Skill
 *
 * @ORM\Table(name="skill")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SkillRepository")
 */
class Skill
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
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Koks Tavo gebėjimas? Užpildyk šį lauką")
     * @Assert\Length(max=55)
     */
    private $title;

    /**
     * @var UserSeeker
     *
     * @ORM\ManyToOne(targetEntity="UserSeeker", inversedBy="skills")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return Skill
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param UserSeeker
     *
     * @return Skill
     */
    public function setUser(UserSeeker $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return UserSeeker
     */
    public function getUser()
    {
        return $this->user;
    }
}
