<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CV
 *
 * @ORM\Table(name="cv")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CVRepository")
 */
class CV
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
     * @ORM\Column(name="title", type="string")
     *
     * @Assert\NotBlank(message="Kokia šiuo metu Tavo profesija? Užpildyk šį lauką")
     */
    private $title;

    /**
     * @var array
     *
     * @ORM\Column(name="skills", type="array")
     *
     * @Assert\NotBlank(message="Kokie tavo gebėjimai? Užpildyk šį lauką")
     */
    private $skills;

    /**
     * @var string
     *
     * @ORM\Column(name="hobbies", type="string", length=255, nullable=true)
     */
    private $hobbies;


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
     * @return CV
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
     * Set skills
     *
     * @param array $skills
     *
     * @return CV
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * Get skills
     *
     * @return array
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Set hobbies
     *
     * @param string $hobbies
     *
     * @return CV
     */
    public function setHobbies($hobbies)
    {
        $this->hobbies = $hobbies;

        return $this;
    }

    /**
     * Get hobbies
     *
     * @return string
     */
    public function getHobbies()
    {
        return $this->hobbies;
    }
}

