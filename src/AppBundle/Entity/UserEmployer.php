<?php

namespace AppBundle\Entity;

use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_employer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserEmployerRepository")
 * @UniqueEntity(fields = "username", targetClass = "AppBundle\Entity\User", message="fos_user.username.already_used")
 * @UniqueEntity(fields = "email", targetClass = "AppBundle\Entity\User", message="Vartotojas su tokiu adresu jau yra")
 * @Vich\Uploadable
 */
class UserEmployer extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "Įrašykite įmonės pavadinimą")
     * @Assert\Length(max=55)
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * Many UserEmployer has One Sector.
     * @ORM\ManyToOne(targetEntity="Sector")
     * @ORM\JoinColumn(name="sector", referencedColumnName="id")
     */
    protected $sector;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(max=12)
     */
    protected $phone;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="employer_logo", fileNameProperty="photo")
     *
     * @var File
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $photo;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(max=55)
     */
    protected $city;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * One UserEmployer has Many JobAd.
     * @ORM\OneToMany(targetEntity="JobAd", mappedBy="employer")
     *
     * @var ArrayCollection|JobAd[]
     */
    private $jobAds;

    /**
     * @ORM\Column(name="legal_code", type="string")
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min=7,
     *     max=9
 *     )
     */
    protected $legalEntitysCode;

    public function __construct()
    {
        parent::__construct();
        $this->jobAds = new ArrayCollection();
    }


    // *** Getters and setters ***

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * @param string $sector
     */
    public function setSector($sector)
    {
        $this->sector = $sector;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    // File upload

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return UserEmployer
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return mixed
     */
    public function getJobAd()
    {
        return $this->jobAds;
    }

    /**
     * @param mixed $jobAd
     */
    public function setJobAd($jobAd)
    {
        $this->jobAds = $jobAd;
    }

    /**
     * @param string $legalEntitysCode
     */
    public function setlegalEntitysCode($legalEntitysCode)
    {
        $this->legalEntitysCode = $legalEntitysCode;
    }

    /**
     * @return string
     */
    public function getlegalEntitysCode()
    {
        return $this->legalEntitysCode;
    }
}
