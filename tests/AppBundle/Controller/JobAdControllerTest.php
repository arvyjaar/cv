<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\ORM\LoadEvaluationData;
use AppBundle\DataFixtures\ORM\LoadJobAdData;
use AppBundle\DataFixtures\ORM\LoadJobApplyData;
use AppBundle\DataFixtures\ORM\LoadRequirementData;
use AppBundle\DataFixtures\ORM\LoadSectorData;
use AppBundle\DataFixtures\ORM\LoadSkillData;
use AppBundle\DataFixtures\ORM\LoadUserSeekerData;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\AppBundle\Helper\LogInHelperTest;
use Tests\AppBundle\Helper\FixturesHelperTest;
use AppBundle\DataFixtures\ORM\LoadUserEmployerData;

class JobAdControllerTest extends WebTestCase
{

    public function testIndexMyAds()
    {
        // Create a new client to browse the application
        $client = static::createClient();
        // Load fixtures
        FixturesHelperTest::loadFixtures(
            $client->getContainer(),
            [
                new LoadUserEmployerData(),
                new LoadUserSeekerData(),
                new LoadEvaluationData(),
                new LoadJobAdData(),
                new LoadJobApplyData(),
                new LoadRequirementData(),
                new LoadSectorData(),
                new LoadSkillData(),
            ]
        );
        // Login
        LogInHelperTest::logInUser($client, 'telia@email.com');
        // Go to url and check content
        $crawler = $client->request('GET', '/skelbimai/mano-skelbimai');

        $this->assertEquals(200, $client
            ->getResponse()
            ->getStatusCode(), "Unexpected HTTP status code for GET /skelbimai");

        $this->assertContains('Projekto vadovas IT projektui', $crawler
            ->filter('.job-title')
            ->text());

        $this->assertContains('Projekto vystymas ir palaikymas. Pasyvūs ir aktyvūs pardavimai;
        Aktyvi online ir offline rinkodara; Operatyvus mokymasis naujų IT įgūdžių ir jų pritaikymas.', $crawler
            ->filter('.ad-description')
            ->text());

        $this->assertContains('Kandidatų į šią poziciją: 1', $crawler
            ->filter('.candidates-count-block > a')->text());
    }
}
