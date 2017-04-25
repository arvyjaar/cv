<?php

/**
 * Created by PhpStorm.
 * User: monika
 * Date: 17.4.23
 * Time: 13.16
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Evaluation;

class LoadEvaluationData implements FixtureInterface, OrderedFixtureInterface
{
    public function getOrder()
    {
        return 5;
    }

    public function load(ObjectManager $manager)
    {
        $evaluation1 = new Evaluation();
        $evaluation1->setMark(10);
        $evaluation1->setComment('Puikiai atliktas darbas!');

        $evaluation2 = new Evaluation();
        $evaluation2->setMark(7);
        $evaluation2->setComment('Galima buvo labiau pasistengti.');

        $evaluation3 = new Evaluation();
        $evaluation3->setMark(4);
        $evaluation3->setComment('Prastai...');

        $evaluation4 = new Evaluation();
        $evaluation4->setMark(9);
        $evaluation4->setComment('Geras darbas.');

        $manager->persist($evaluation1);
        $manager->persist($evaluation2);
        $manager->persist($evaluation3);
        $manager->persist($evaluation4);

        $manager->flush();
    }
}
