<?php
/**
 * Created by arvydas.
 * Date: 4/29/17 - Time: 3:02 PM
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Sector;

class LoadSectorData extends AbstractFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        // the order in which fixtures will be loaded
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $sectors = [
            'Kompiuteriai/IT/internetas',
            'Mobilusis, fiksuotas ryšys',
            'Medicina/sveikatos apsauga/farmacija',
            'Administravimas/sekretoriavimas',
            'Apsauga',
            'Apskaita/finansai/auditas',
            'Dizainas/architektūra',
            'Draudimas',
            'Eksportas',
            'Energetika/elektronika',
            'Inžinerija/mechanika',
            'Klientų aptarnavimas/paslaugos',
            'Maisto gamyba',
            'Marketingas/reklama',
            'Nekilnojamasis turtas',
            'Pardavimų vadyba',
            'Personalo valdymas',
            'Pirkimai/tiekimas',
            'Pramonė/gamyba',
            'Žemės ūkis/žuvininkystė',
            'Valstybės tarnyba',
            'Žiniasklaida/viešieji ryšiai',
            'Transporto/logistikos vadyba',
            'Švietimas/mokymai/kultūra',
            'Statyba',
            'Prekyba - konsultavimas',
            'Teisė',
            'Transporto vairavimas'
        ];
        foreach ($sectors as $sector) {
            $entry = new Sector();
            $entry->setTitle($sector);
            $manager->persist($entry);
        }
        $manager->flush();
    }
}
