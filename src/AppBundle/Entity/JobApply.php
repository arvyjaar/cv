<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DateTime;

/**
 * JobApply
 *
 * @ORM\Table(name="job_apply")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobApplyRepository")
 * @Vich\Uploadable
 */
class JobApply
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
     * @ORM\Column(name="cv", type="string", length=255, nullable=true)
     */
    private $cv;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="cv", fileNameProperty="cv")
     * @var File
     */
    protected $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var DateTime
     */
    protected $updatedAt;

    /**
     * One JobApply has One Evaluation.
     * @ORM\OneToOne(targetEntity="Evaluation", inversedBy="jobApply")
     * @ORM\JoinColumn(name="evaluation_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $evaluation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank(message="Prašome įkelti užduoties sprendimą.")
     * @Assert\Url(message="Užduoties sprendimas turi būti pateiktas kaip nuoroda. Pvz.:https://drive.google.com/")
     * @Assert\Length(max=255)
     */
    private $assignmentSolution;

    /**
     * Many JobApply have One JobAd.
     * @ORM\ManyToOne(targetEntity="JobAd", inversedBy="jobApply")
     * @ORM\JoinColumn(name="job_ad_id", referencedColumnName="id", nullable=false)
     */
    private $jobAd;

    /**
     * Many JobApply have One UserSeeker.
     * @ORM\ManyToOne(targetEntity="UserSeeker", inversedBy="jobApply")
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
     * @param string $cv
     *
     * @return JobApply
     */
    public function setCv($cv)
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * @return string
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * @param File|UploadedFile $image
     *
     * @return JobApply
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
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return string
     */
    public function getAssignmentSolution()
    {
        return $this->assignmentSolution;
    }

    /**
     * @param string $assignmentSolution
     */
    public function setAssignmentSolution($assignmentSolution)
    {
        $this->assignmentSolution = $assignmentSolution;
    }

    /**
     * @return UserSeeker
     */
    public function getOwner()
    {
        return $this->user;
    }

    /**
     * @param UserSeeker
     */
    public function setOwner($user)
    {
        $this->user = $user;
    }

    /**
     * @return JobAd
     */
    public function getJobAd()
    {
        return $this->jobAd;
    }

    /**
     * @param JobAd
     */
    public function setJobAd(JobAd $jobAd)
    {
        $this->jobAd = $jobAd;
    }

    /**
     * @return Evaluation
     */
    public function getEvaluation()
    {
        return $this->evaluation;
    }

    /**
     * @param Evaluation
     */
    public function setEvaluation(Evaluation $evaluation)
    {
        $this->evaluation = $evaluation;
    }
}
