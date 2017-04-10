<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Evaluation;
use AppBundle\Entity\JobAd;

/**
 * JobApply
 *
 * @ORM\Table(name="job_apply")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JobApplyRepository")
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
     * @ORM\Column(name="cv", type="string", length=255)
     */
    private $cv;

    /**
     * One JobApply has One Evaluation.
     * @ORM\OneToOne(targetEntity="Evaluation", inversedBy="jobApply")
     * @ORM\JoinColumn(name="evaluation_id", referencedColumnName="id")
     */
    private $evaluation;

    /**
     * Many JobApply have One JobAd.
     * @ORM\ManyToOne(targetEntity="JobAd", inversedBy="jobApply")
     * @ORM\JoinColumn(name="jobAd_id", referencedColumnName="id")
     */
    private $jobAd;

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
     * Set cv
     *
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
     * Get cv
     *
     * @return string
     */
    public function getCv()
    {
        return $this->cv;
    }
}

