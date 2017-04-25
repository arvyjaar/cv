<?php
/**
 * Created by PhpStorm.
 * User: monika
 * Date: 17.4.23
 * Time: 14.25
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Requirement;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\JobAd;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadRequirementData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
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
        return 7;
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

    public function load(ObjectManager $manager)
    {
        $requirement1 = new Requirement();
        $requirement1->setTitle('php');
        $requirement1->setJobAd($this->getJobAd(1));

        $requirement2 = new Requirement();
        $requirement2->setTitle('sql');
        $requirement2->setJobAd($this->getJobAd(1));

        $requirement3 = new Requirement();
        $requirement3->setTitle('c#');
        $requirement3->setJobAd($this->getJobAd(2));

        $requirement4 = new Requirement();
        $requirement4->setTitle('javascript');
        $requirement4->setJobAd($this->getJobAd(2));

        $requirement5 = new Requirement();
        $requirement5->setTitle('javascript');
        $requirement5->setJobAd($this->getJobAd(4));

        $requirement6 = new Requirement();
        $requirement6->setTitle('javascript');
        $requirement6->setJobAd($this->getJobAd(3));

        $manager->persist($requirement1);
        $manager->persist($requirement2);
        $manager->persist($requirement3);
        $manager->persist($requirement4);
        $manager->persist($requirement5);
        $manager->persist($requirement6);

        $manager->flush();
    }
}
