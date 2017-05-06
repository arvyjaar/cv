<?php

namespace tests\Crawler;

use AppBundle\Crawler\SalaryCrawler;
use PHPUnit\Framework\TestCase;

class SalaryCrawlerTest extends TestCase
{
    /**
     * @var SalaryCrawler
     */
    private $crawler;

    /**
     * @return SalaryCrawler
     */
    public function setUp()
    {
        $this->crawler = new SalaryCrawler();
    }

    public function tearDown()
    {
        $this->crawler = null;
    }

    public function addDataProvider()
    {
        return array(
            array('123033512', 554.72),
            array('135867375', 2046.59),
            array('1222222222', null),
        );
    }

    /**
     * @dataProvider addDataProvider
     */
    public function testFormatter($legalCode, $expected){

        $result = $this->crawler->fetchSalary($legalCode);
        $this->assertEquals($expected, $result);
    }
}
