<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class JobAdRepository extends EntityRepository
{
    /**
     * @param string $keyword
     * @return array
     */
    public function searchAds($keyword)
    {
        $qb = $this->createQueryBuilder('ja');
        $qb->select('ja');

        if ($keyword) {
            $qb->where('ja.title LIKE :keyword')
                ->setParameter('keyword', '%' . $keyword . '%');
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $keyword
     * @param object $user
     * @return array
     */
    public function searchMyAds($keyword, $user)
    {
        $qb = $this->createQueryBuilder('ja');
        $qb->select('ja')
            ->where('ja.employer = :employer')
            ->setParameter('employer', $user);

        if ($keyword) {
            $qb->andWhere('ja.title LIKE :keyword')
                ->setParameter('keyword', '%' . $keyword . '%');
        }

        return $qb->getQuery()->getResult();
    }
}
