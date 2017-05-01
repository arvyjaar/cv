<?php

namespace AppBundle\Repository;

class UserEmployerRepository extends \Doctrine\ORM\EntityRepository
{
    public function searchEmployers($title, $sector)
    {
        $qb = $this->createQueryBuilder('emp');
        $qb->select('emp');
        if ($title) {
            $qb->where('emp.title LIKE :title')
                ->setParameter('title', '%' . $title . '%');
        }
        if ($sector) {
            $qb->andWhere('emp.sector = :sector')
                ->setParameter('sector', $sector);
        }

        return $qb->getQuery()->getResult();
    }
}
