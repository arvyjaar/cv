<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\UserEmployer;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Requirement;

/**
 * JobAd
 *
 * @ORM\Table(name="job_ad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobAdRepository")
 */
class JobAd
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
     * One JobAd has Many JobApply.
     * @ORM\OneToMany(targetEntity="JobApply", mappedBy="jobAd")
     */
    private $jobApply;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Assert\NotBlank(message = "Kokias pareigas siūlai kandidatams? Užpildyk šį lauką")
     * @Assert\Length(max=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank(message = "Trumpai papasakok apie siūlomą poziciją. Užpildyk šį lauką")
     * @Assert\Length(max=300)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="assignment", type="string", nullable=false)
     * @Assert\NotBlank(message = "Įkelk užduotį kandidatams!")
     * @Assert\Url(message="Užduotis turi būti pateikta kaip nuoroda. Pvz.:https://drive.google.com/")
     * @Assert\Length(max=255)
     */
    private $assignment;

    /**
     * @var ArrayCollection|Requirement[]
     *
     * @ORM\OneToMany(targetEntity="Requirement", mappedBy="jobAd")
     */
    private $requirements;

    /**
     * Many JobAd have One UserEmployer.
     * @ORM\ManyToOne(targetEntity="UserEmployer", inversedBy="jobAds")
     * @ORM\JoinColumn(name="employer_id", referencedColumnName="id", nullable=false)
     */
    private $employer;

    public function __construct()
    {
        $this->requirements = new ArrayCollection();
        $this->jobApply = new ArrayCollection();
    }

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
     * @return JobAd
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
     * @param string $description
     *
     * @return JobAd
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * @param string $assignment
     *
     * @return JobAd
     */
    public function setAssignment($assignment)
    {
        $this->assignment = $assignment;

        return $this;
    }

    /**
     * @return string
     */
    public function getAssignment()
    {
        return $this->assignment;
    }

    /**
     * @return ArrayCollection|Requirement[]
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * @param ArrayCollection $requirements
     * @return JobAd
     */
    public function setRequirements($requirements)
    {
        $this->skills = $requirements;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getJobApply()
    {
        return $this->jobApply;
    }

    /**
     * @param JobApply
     */
    public function setJobApply(JobApply $jobApply)
    {
        $this->jobApply = $jobApply;
    }

    /**
     * @return UserEmployer
     */
    public function getOwner()
    {
        return $this->employer;
    }

    /**
     * @param UserEmployer
     * @return JobAd
     */
    public function setOwner($employer)
    {
        $this->employer = $employer;

        return $this;
    }
}
