<?php

namespace AppBundle\Entity;

use PUGX\MultiUserBundle\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

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
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * Many UserEmployer has One Sector.
     * @ORM\ManyToOne(targetEntity="Sector")
     * @ORM\JoinColumn(name="sector", referencedColumnName="id")
     */
    private $sector;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(max=12)
     */
    private $phone;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="employer_logo", fileNameProperty="photo")
     * @var File
     *
     * @Assert\File(
     *     maxSize = "2048Ki"
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Length(max=55)
     */
    private $city;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

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
    private $legalEntitysCode;

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
     * @return UserEmployer
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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
     * @return UserEmployer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
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
     * @return UserEmployer
     */
    public function setSector($sector)
    {
        $this->sector = $sector;

        return $this;
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
     * @return UserEmployer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
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
     * @return UserEmployer
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
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
     * @return UserEmployer
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
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
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     * @return UserEmployer
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getJobAd()
    {
        return $this->jobAds;
    }

    /**
     * @param JobAd $jobAd
     * @return UserEmployer
     */
    public function setJobAd($jobAd)
    {
        $this->jobAds = $jobAd;

        return $this;
    }

    /**
     * @param string $legalEntitysCode
     * @return UserEmployer
     */
    public function setlegalEntitysCode($legalEntitysCode)
    {
        $this->legalEntitysCode = $legalEntitysCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getlegalEntitysCode()
    {
        return $this->legalEntitysCode;
    }
}
