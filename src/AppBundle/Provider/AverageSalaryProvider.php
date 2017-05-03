<?php
/**
 * Created by PhpStorm.
 * User: monika
 * Date: 17.5.2
 * Time: 14.08
 */

namespace AppBundle\Provider;

use AppBundle\Crawler\SalaryCrawler;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use DateTime;

// TODO refactor this class and its methods
class AverageSalaryProvider
{
    private $salaryCrawler;

    public function __construct(SalaryCrawler $salaryCrawler)
    {
        $this->salaryCrawler = $salaryCrawler;
    }

    public function getSalary($legalEntitysCode)
    {
        $cache = new FilesystemAdapter();
        $cachedValues = $cache->getItem($legalEntitysCode);

        if ($cachedValues->isHit()) {
            $cachedData = $cachedValues->get();
            $salary = $cachedData[$legalEntitysCode];
        } else {
            //TODO: if service is down or takes too long - skip fetching, don't display salary on twig
            $salary = $this->salaryCrawler->fetchSalary($legalEntitysCode);

            $cachedValues->set([
                $legalEntitysCode => $salary,
            ]);

            $firstDayOfNextMonth = date_modify(new DateTime('now'), 'first day of +1 month 00:00:00');
            $cachedValues->expiresAt($firstDayOfNextMonth);
            $cache->save($cachedValues);
        }

        return $salary;
    }
}
