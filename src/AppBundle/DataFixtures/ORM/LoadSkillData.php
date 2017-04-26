<?php

/**
 * Created by PhpStorm.
 * User: monika
 * Date: 17.4.23
 * Time: 14.17
 */

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
        return 3;
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

        $manager->persist($skill1);
        $manager->persist($skill2);
        $manager->persist($skill3);
        $manager->persist($skill4);

        $manager->flush();
    }
}
