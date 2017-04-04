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
     * @ORM\Column(name="name", type="string")
     *
     * @Assert\NotBlank(message="Kuo tu vardu? Užpildyk šį lauką")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string")
     *
     * @Assert\NotBlank(message="Kokia tavo pavardė? Užpildyk šį lauką")
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string")
     *
     * @Assert\NotBlank(message="Koks tavo el. pašto adresas? Užpildyk šį lauką")
     * @Assert\Email(message="Klaidingas el. pašto adresas")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=50)
     *
     * @Assert\NotBlank(message="Koks tavo telefono numeris? Užpildyk šį lauką")
     */
    private $phone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateOfBirth", type="date")
     *
     * @Assert\NotBlank(message="Kokia tavo gimimo data? Užpildyk šį lauką")
     * @Assert\Date(message="Klaidingas datos formatas")
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     *
     * @Assert\NotBlank(message="Kokia šiuo metu Tavo profesija? Užpildyk šį lauką")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     *
     */
    private $photo;

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
     * Set name
     *
     * @param string $name
     *
     * @return CV
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
     * @return CV
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
     * Set email
     *
     * @param string $email
     *
     * @return CV
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return CV
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return CV
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
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
     * Set photo
     *
     * @param string $photo
     *
     * @return CV
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
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

