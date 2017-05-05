<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Skill;
use AppBundle\Entity\UserSeeker;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSkillData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
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
        return 4;
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

    public function load(ObjectManager $manager)
    {
        $skill1 = new Skill();
        $skill1->setTitle('php');
        $skill1->setUser($this->getOwner(1));

        $skill2 = new Skill();
        $skill2->setTitle('sql');
        $skill2->setUser($this->getOwner(1));

        $skill3 = new Skill();
        $skill3->setTitle('c#');
        $skill3->setUser($this->getOwner(2));

        $skill4 = new Skill();
        $skill4->setTitle('javascript');
        $skill4->setUser($this->getOwner(2));

        $skill5 = new Skill();
        $skill5->setTitle('javascript');
        $skill5->setUser($this->getOwner(3));

        $skill6 = new Skill();
        $skill6->setTitle('project management');
        $skill6->setUser($this->getOwner(4));

        $skill7 = new Skill();
        $skill7->setTitle('project management');
        $skill7->setUser($this->getOwner(5));

        $skill8 = new Skill();
        $skill8->setTitle('php');
        $skill8->setUser($this->getOwner(6));

        $skill9 = new Skill();
        $skill9->setTitle('php');
        $skill9->setUser($this->getOwner(7));

        $skill10 = new Skill();
        $skill10->setTitle('php');
        $skill10->setUser($this->getOwner(8));

        $skill11 = new Skill();
        $skill11->setTitle('php');
        $skill11->setUser($this->getOwner(9));

        $skill12 = new Skill();
        $skill12->setTitle('php');
        $skill12->setUser($this->getOwner(10));

        $skill13 = new Skill();
        $skill13->setTitle('php');
        $skill13->setUser($this->getOwner(11));

        $manager->persist($skill1);
        $manager->persist($skill2);
        $manager->persist($skill3);
        $manager->persist($skill4);
        $manager->persist($skill5);
        $manager->persist($skill6);
        $manager->persist($skill7);
        $manager->persist($skill8);
        $manager->persist($skill9);
        $manager->persist($skill10);
        $manager->persist($skill11);
        $manager->persist($skill12);
        $manager->persist($skill13);

        $manager->flush();
    }
}
