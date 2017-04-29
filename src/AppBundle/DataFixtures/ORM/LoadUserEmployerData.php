<?php

/**
 * Created by PhpStorm.
 * User: monika
 * Date: 17.4.23
 * Time: 10.26
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\UserEmployer;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserEmployerData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
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
        return 2;
    }

    public function getSector($id)
    {
        $sector = $this->container->get('doctrine')
            ->getRepository('AppBundle:Sector')
            ->find($id);
        return $sector;
    }

    public function load(ObjectManager $manager)
    {
        $employer1 = new UserEmployer();
        $employer1->setTitle('Cgates');
        $employer1->setSector($this->getSector(1));
        $employer1->setCity('Vilnius');
        $employer1->setPhone('+37061358794');
        $employer1->setDescription('Šviesolaidinio interneto, skaiteninės televizijos bei fiksuotojo telefono ryšio 
            paslaugos. INIT - lietuviško kapitalo telekomunikacijų bendrovė, savo veiklą pradėjusi nuo 1990 m. šiandien 
            yra trečia pagal dydį telekomunikacijų paslaugų teikėja Lietuvoje. Šiuo metu paslaugas teikiame: Vilniuje, 
            Kaune, Mažeikiuose.');
        $employer1->setEmail('cgates@email.com');
        // password encoding
        $employer1->setEnabled(true);
        $employer1->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($employer1, '123456');
        $employer1->setPassword($password);

        $employer2 = new UserEmployer();
        $employer2->setTitle('NFQ Technologies');
        $employer2->setSector($this->getSector(1));
        $employer2->setCity('Vilnius');
        $employer2->setPhone('+370613555555');
        $employer2->setDescription('Programinės įrangos kūrimas, elektroninio verslo sprendimai, internetinių 
            svetainių kūrimas.');
        $employer2->setEmail('nfq@email.com');
        // password encoding
        $employer2->setEnabled(true);
        $employer2->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($employer2, '123456');
        $employer2->setPassword($password);

        $employer3 = new UserEmployer();
        $employer3->setTitle('Microsoft Lietuva');
        $employer3->setSector($this->getSector(1));
        $employer3->setCity('Vilnius');
        $employer3->setPhone('+370613123456');
        $employer3->setDescription('Microsoft atstovybė Lietuvoje. Programinė įranga, didmeninė ir mažmeninė prekyba.');
        $employer3->setEmail('microsoft@email.com');
        // password encoding
        $employer3->setEnabled(true);
        $employer3->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($employer3, '123456');
        $employer3->setPassword($password);

        $employer4 = new UserEmployer();
        $employer4->setTitle('Blue Bridge');
        $employer4->setSector($this->getSector(1));
        $employer4->setCity('Vilnius');
        $employer4->setPhone('+370614155888');
        $employer4->setDescription('„Blue Bridge“ teikia kompleksines IT paslaugas ir sprendimus stambioms verslo bei 
            valstybinėms organizacijoms. Kompetencijos sritys: debesų kompiuterija, IT valdymas ir priežiūra, duomenų 
            perdavimas ir kibernetinis saugumas, serveriai ir duomenų saugyklos, infrastruktūros valdymas.');
        $employer4->setEmail('bluebridge@email.com');
        // password encoding
        $employer4->setEnabled(true);
        $employer4->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($employer4, '123456');
        $employer4->setPassword($password);

        $employer5 = new UserEmployer();
        $employer5->setTitle('Telia');
        $employer5->setSector($this->getSector(2));
        $employer5->setCity('Vilnius');
        $employer5->setPhone('+370614145789');
        $employer5->setDescription('2017 m. vasario 1 d. „Teo“, „Omnitel“ ir „Baltic Data Center“ tapo viena įmone - 
            „Telia Lietuva“. Nuo šiol telekomunikacijų, IT ir TV paslaugas teikiame iš vienų rankų. TEO įmonių grupė 
            yra didžiausios Šiaurės ir Baltijos šalių telekomunikacijų bendrovės "TeliaSonera AB (publ)" įmonių 
            grupės dalis.');
        $employer5->setEmail('telia@email.com');
        // password encoding
        $employer5->setEnabled(true);
        $employer5->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($employer5, '123456');
        $employer5->setPassword($password);

        $employer6 = new UserEmployer();
        $employer6->setTitle('Sicor Biotech');
        $employer6->setSector($this->getSector(3));
        $employer6->setCity('Vilnius');
        $employer6->setPhone('+370614145789');
        $employer6->setDescription('UAB "Sicor Biotech" – biotechnologinės farmacijos įmonė, kurianti ir gaminanti 
            rekombinantinius biofarmacinius preparatus pagal pažangiausias mokslo ir gamybos technologijas.');
        $employer6->setEmail('sicorbiotech@email.com');
        // password encoding
        $employer6->setEnabled(true);
        $employer6->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($employer6, '123456');
        $employer6->setPassword($password);

        $employer7 = new UserEmployer();
        $employer7->setTitle('EIS Group Lietuva');
        $employer7->setSector($this->getSector(1));
        $employer7->setCity('Vilnius');
        $employer7->setPhone('+370614145888');
        $employer7->setDescription('Kompiuterinių programų kūrimas.');
        $employer7->setEmail('eisgroup@email.com');
        // password encoding
        $employer7->setEnabled(true);
        $employer7->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($employer7, '123456');
        $employer7->setPassword($password);

        $employer8 = new UserEmployer();
        $employer8->setTitle('Baltic Amadeus');
        $employer8->setSector($this->getSector(1));
        $employer8->setCity('Vilnius');
        $employer8->setPhone('+370614178945');
        $employer8->setDescription('Esame komanda, kurianti kokybiškus IT sprendimus pasaulinėms telekomunikacijų, 
            finansų ir logistikos rinkoms. Patirtis įvairiose verslo srityse, kaupta nuo pat įmonės įkūrimo 1988 m. 
            rugsėjo 27 d., leidžia mums būti universaliems, priimti ir realizuoti bet kokį klientų siūlomą iššūkį.');
        $employer8->setEmail('balticamadeus@email.com');
        // password encoding
        $employer8->setEnabled(true);
        $employer8->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($employer8, '123456');
        $employer8->setPassword($password);

        $employer9 = new UserEmployer();
        $employer9->setTitle('Devbridge');
        $employer9->setSector($this->getSector(1));
        $employer9->setCity('Vilnius');
        $employer9->setPhone('+370614145612');
        $employer9->setDescription('Programinės įrangos kūrimas, elektroninio verslo sprendimai, 
            internetinių svetainių kūrimas.');
        $employer9->setEmail('devbridge@email.com');
        // password encoding
        $employer9->setEnabled(true);
        $employer9->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($employer9, '123456');
        $employer9->setPassword($password);

        $employer10 = new UserEmployer();
        $employer10->setTitle('Nasdaq');
        $employer10->setSector($this->getSector(6));
        $employer10->setCity('Vilnius');
        $employer10->setPhone('+370614178945');
        $employer10->setDescription('Vertybinių Vertybinių popierių birža „Nasdaq Vilnius” priklauso didžiausiai 
            biržų operatorei pasaulyje Nasdaq. Lietuvoje vertybinių popierių birža „Nasdaq Vilnius” yra vieninetelė 
            reguliuojamos rinkos operatorė, teikianti vertybinių popierių prekybos, listingo bei 
            informacines paslaugas.');
        $employer10->setEmail('nasdaq@email.com');
        // password encoding
        $employer10->setEnabled(true);
        $employer10->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($employer10, '123456');
        $employer10->setPassword($password);

        $employer11 = new UserEmployer();
        $employer11->setTitle('Google');
        //$employer11->setSector('IT');
        $employer11->setCity('Vilnius');
        $employer11->setPhone('+370614133333');
        $employer11->setDescription('Pasaulinė GOOGLE paieškos sistema Lietuvoje.');
        $employer11->setEmail('google@email.com');
        // password encoding
        $employer11->setEnabled(true);
        $employer11->setSalt(md5(uniqid()));
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($employer11, '123456');
        $employer11->setPassword($password);

        $manager->persist($employer1);
        $manager->persist($employer2);
        $manager->persist($employer3);
        $manager->persist($employer4);
        $manager->persist($employer5);
        $manager->persist($employer6);
        $manager->persist($employer7);
        $manager->persist($employer8);
        $manager->persist($employer9);
        $manager->persist($employer10);
        $manager->persist($employer11);

        $manager->flush();
    }
}
