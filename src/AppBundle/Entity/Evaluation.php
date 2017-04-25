<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\JobApply;

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
     * @Assert\Length(max=300)
     */
    private $comment;


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
     * One Evaluation has One JobApply.
     * @ORM\OneToOne(targetEntity="JobApply", mappedBy="evaluation")
     */
    private $jobApply;

    /**
     * Set mark
     *
     * @param integer $mark
     *
     * @return Evaluation
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return int
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set comment
     *
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
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
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
}
