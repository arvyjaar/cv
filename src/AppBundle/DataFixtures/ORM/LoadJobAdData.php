<?php

/**
 * Created by PhpStorm.
 * User: monika
 * Date: 17.4.23
 * Time: 11.51
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\JobAd;
use AppBundle\Entity\UserEmployer;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadJobAdData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
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
     * @var UserEmployer
     */
    public function getOwner($id)
    {
        $owner = $this->container->get('doctrine')
            ->getRepository('AppBundle:UserEmployer')
            ->find($id);
        return $owner;
    }

    public function load(ObjectManager $manager)
    {
        $jobAd1 = new JobAd();
        $jobAd1->setTitle('Web Application Developer');
        $jobAd1->setDescription('Joberate is expanding operations in Lithuania and are looking for creative and highly
            intelligent developers with technical and scientific educational backgrounds. We are also looking for 
            motivated or self taught programmers. The successful candidate must have a passion for programming, and 
            show demonstrable expertise in more than one modern programming languages. Responsibilities include but are 
            not limited to: ⚬design, code, and support a new data analytics platform; 
        ⚬Create and support various applications, APIs, and 3rd party tools;
        ⚬Create system architecture and design, and tune and optimize code;
        ⚬Provide ongoing data quality monitoring and support.');
        $jobAd1->setAssignment('https://drive.google.com/open?id=1Qu5RM-ZuZhFdmEdKKwKQM5d-BMPDpnyuuK0yXPmK3qk');
        $jobAd1->setOwner($this->getOwner(14));

        $jobAd2 = new JobAd();
        $jobAd2->setTitle('Frontend/JavaScript Developer');
        $jobAd2->setDescription('- Programavimas tarptautinių turizmo el. verslo sistemų (B2B/B2C) kūrimo komandoje;
        - Funkcinių komponentų programavimas AngularJS karkaso pagrindu;
        - Frontend dalies programavimas.
        ');
        $jobAd2->setAssignment('https://drive.google.com/open?id=1Qu5RM-ZuZhFdmEdKKwKQM5d-BMPDpnyuuK0yXPmK3qk');
        $jobAd2->setOwner($this->getOwner(15));

        $jobAd3 = new JobAd();
        $jobAd3->setTitle('Projekto vadovas IT projektui');
        $jobAd3->setDescription('•	Projekto vystymas ir palaikymas. Pasyvūs ir aktyvūs
        pardavimai;
        •	Aktyvi online ir offline rinkodara;
        •	Operatyvus mokymasis naujų IT įgūdžių ir jų pritaikymas.');
        $jobAd3->setAssignment('https://drive.google.com/open?id=1Qu5RM-ZuZhFdmEdKKwKQM5d-BMPDpnyuuK0yXPmK3qk');
        $jobAd3->setOwner($this->getOwner(16));

        $jobAd4 = new JobAd();
        $jobAd4->setTitle('Full Stack PHP programuotojas');
        $jobAd4->setDescription('- Spartus elektroninės komercijos WEB/MOBILE tobulinimas ir naujausių programavimo 
            technologijų diegimas (darbas su Frontend ir Backend dalimis);
        - Naujų elektroninės komercijos sistemų funkcijų programavimas;
        - Esamų sistemų priežiūra ir tobulinimas.');
        $jobAd4->setAssignment('https://drive.google.com/open?id=1Qu5RM-ZuZhFdmEdKKwKQM5d-BMPDpnyuuK0yXPmK3qk');
        $jobAd4->setOwner($this->getOwner(17));

        $manager->persist($jobAd1);
        $manager->persist($jobAd2);
        $manager->persist($jobAd3);
        $manager->persist($jobAd4);

        $manager->flush();
    }
}
