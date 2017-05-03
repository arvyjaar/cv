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

class AverageSalaryProvider
{
    /**
     * @var SalaryCrawler
     */
    private $salaryCrawler;

    /**
     * @param SalaryCrawler $salaryCrawler
     */
    public function __construct(SalaryCrawler $salaryCrawler)
    {
        $this->salaryCrawler = $salaryCrawler;
    }

    /**
     * @param string $legalEntitysCode
     *
     * @return mixed
     */
    public function getSalary($legalEntitysCode)
    {
        $cache = new FilesystemAdapter();
        $cachedValues = $cache->getItem($legalEntitysCode);

        if ($cachedValues->isHit()) {
            $cachedData = $cachedValues->get();
            $salary = $cachedData[$legalEntitysCode];
        } else {
            $salary = $this->salaryCrawler->fetchSalary($legalEntitysCode);

            if ($salary == null) {
                return $salary;
            }

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
