<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\UserEmployer;

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
     * @ORM\Column(name="assignment", type="string")
     *
     * @Assert\NotBlank(message="Pateik užduotį kandidatui - užpildyk šį lauką!")
     */
    private $assignment;

    /**
     * @var array
     *
     * @ORM\Column(name="requirements", type="text")
     *
     * @Assert\NotBlank(message="Būtu šaunu, jei apibrėžtum aiškius reikalavimus kandidatams. Užpildyk šį lauką")
     */
    private $requirements;

    /**
     * Many JobAd have One UserEmployer.
     * @ORM\ManyToOne(targetEntity="UserEmployer", inversedBy="jobAd")
     * @ORM\JoinColumn(name="employer_id", referencedColumnName="id")
     */
    private $employer;

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
     * @return JobAd
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
     * Set description
     *
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
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set assignment
     *
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
     * Get assignment
     *
     * @return string
     */
    public function getAssignment()
    {
        return $this->assignment;
    }

    /**
     * Set requirements
     *
     * @param array $requirements
     *
     * @return JobAd
     */
    public function setRequirements($requirements)
    {
        $this->requirements = $requirements;

        return $this;
    }

    /**
     * Get requirements
     *
     * @return array
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * @return mixed
     */
    public function getJobApply()
    {
        return $this->jobApply;
    }

    /**
     * @param mixed $jobApply
     */
    public function setJobApply($jobApply)
    {
        $this->jobApply = $jobApply;
    }

    /**
     * @return mixed
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * @param mixed $employer
     */
    public function setEmployer($employer)
    {
        $this->employer = $employer;
    }
}

