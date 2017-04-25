<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Requirement
 *
 * @ORM\Table(name="requirement")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RequirementRepository")
 */
class Requirement
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
     * @Assert\NotBlank(message="Kokių gebėjimų reikalauja ši pozicija? Užpildyk šį lauką")
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="JobAd", inversedBy="requirements")
     * @ORM\JoinColumn(name="ad_id", referencedColumnName="id")
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
     * Set title
     *
     * @param string $title
     *
     * @return Requirement
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
     * @param object $jobAd
     *
     * @return Requirement
     */
    public function setJobAd($jobAd)
    {
        $this->jobAd = $jobAd;

        return $this;
    }

    /**
     * Get jobAd
     *
     * @return string
     */
    public function getJobAd()
    {
        return $this->jobAd;
    }
}
