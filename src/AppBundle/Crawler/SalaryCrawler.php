<?php

/**
 * Created by PhpStorm.
 * User: monika
 * Date: 17.5.1
 * Time: 16.17
 */
namespace AppBundle\Crawler;

use Goutte\Client;

class SalaryCrawler
{
    public function fetchSalary($legalEntitysCode)
    {
        $client = new Client();
        $crawler = $client->request('GET', 'http://rekvizitai.vz.lt/');

        $form = $crawler->selectButton('Ieškoti')->form(array(
            'code' => $legalEntitysCode
        ));

        $crawler = $client->submit($form);

        $link = $crawler->filter('a[class="firmTitle"]')->attr('href');
        $crawler = $client->request('GET', $link);

        $salary = $crawler->filter('tr:contains("Vidutinis atlyginimas") > td:contains("€")')->text();

        $salary = (float) substr($salary, 0, strpos($salary, "€"));

        return $salary;
    }
}
