<?php

/**
 * Created by PhpStorm.
 * User: monika
 * Date: 17.4.23
 * Time: 12.41
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\JobApply;
use AppBundle\Entity\UserSeeker;
use AppBundle\Entity\JobAd;
use AppBundle\Entity\Evaluation;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadJobApplyData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getOrder()
    {
        return 6;
    }

    /**
     * @var UserSeeker
     */
    public function getOwner($id)
    {
        $owner = $this->container->get('doctrine')
            ->getRepository('AppBundle:UserSeeker')
            ->find($id);
        return $owner;
    }

    /**
     * @var JobAd
     */
    public function getJobAd($id)
    {
        $jobAd = $this->container->get('doctrine')
            ->getRepository('AppBundle:JobAd')
            ->find($id);
        return $jobAd;
    }

    /**
     * @var Evaluation
     */
    public function getEvaluation($id)
    {
        $evaluation = $this->container->get('doctrine')
            ->getRepository('AppBundle:Evaluation')
            ->find($id);
        return $evaluation;
    }

    public function load(ObjectManager $manager)
    {
        $jobAplly1 = new JobApply();
        $jobAplly1->setAssignmentSolution('https://goo.gl/bphynd');
        $jobAplly1->setCv('example-cv.pdf');
        $jobAplly1->setOwner($this->getOwner(1));
        $jobAplly1->setJobAd($this->getJobAd(4));
        $jobAplly1->setEvaluation($this->getEvaluation(4));

        $jobAplly2 = new JobApply();
        $jobAplly2->setAssignmentSolution('https://goo.gl/4UZi2T');
        $jobAplly2->setCv('example-cv.pdf');
        $jobAplly2->setOwner($this->getOwner(2));
        $jobAplly2->setJobAd($this->getJobAd(1));
        $jobAplly2->setEvaluation($this->getEvaluation(3));


        $jobAplly3 = new JobApply();
        $jobAplly3->setAssignmentSolution('https://goo.gl/LR4NaW');
        $jobAplly3->setCv('example-cv.pdf');
        $jobAplly3->setOwner($this->getOwner(3));
        $jobAplly3->setJobAd($this->getJobAd(3));
        $jobAplly3->setEvaluation($this->getEvaluation(2));

        $manager->persist($jobAplly1);
        $manager->persist($jobAplly2);
        $manager->persist($jobAplly3);

        $manager->flush();
    }
}
