<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EvaluationRepository")
 */
class Evaluation
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
     * @var int
     *
     * @ORM\Column(name="mark", type="integer")
     *
     * @Assert\NotBlank(message = "Kokiu pažymiu(1-10) įvertinsi šį kandidatą? Užpildyk šį lauką")
     * @Assert\Range(
     *      min = 1,
     *      max = 10,
     *      minMessage = "Įvertinimas negali būti žemesnis nei {{ limit }}",
     *      maxMessage = "Įvertinimas negali būti didesnis nei {{ limit }}"
     * )
     */
    private $mark;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     *
     * @Assert\Length(max=255)
     */
    private $comment;

    /**
     * @var JobApply
     *
     * One Evaluation has One JobApply.
     * @ORM\OneToOne(targetEntity="JobApply", mappedBy="evaluation")
     */
    private $jobApply;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $mark
     *
     * @return Evaluation
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * @return int
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param string $comment
     *
     * @return Evaluation
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return JobApply
     */
    public function getJobApply()
    {
        return $this->jobApply;
    }

    /**
     * @param JobApply
     * @return Evaluation
     */
    public function setJobApply(JobApply $jobApply)
    {
        $this->jobApply = $jobApply;

        return $this;
    }
}
