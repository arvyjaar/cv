<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserEmployerRepository extends EntityRepository
{
    /**
     * @param string|null $title
     * @param int|null $sector
     * @return array
     */
    public function searchEmployers($title, $sector)
    {
        $qb = $this->createQueryBuilder('emp');
        $qb->select('emp');
        if (! empty($title)) {
            $qb->where('emp.title LIKE :title')
                ->setParameter('title', '%' . $title . '%');
        }
        if (! empty($sector)) {
            $qb->andWhere('emp.sector = :sector')
                ->setParameter('sector', $sector);
        }

        return $qb->getQuery()->getResult();
    }
}
