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
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT a
            FROM AppBundle:JobAd a
            LEFT JOIN a.requirements r
            WHERE a.title LIKE :title
            OR r.title LIKE :title
            ')
            ->setParameter('title', '%' . $keyword . '%');

        return $query->getResult();
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
