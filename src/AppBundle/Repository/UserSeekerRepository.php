<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserSeekerRepository extends EntityRepository
{
    /**
     * @param string $title
     * @return array
     */
    public function findSeekers($title)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('
            SELECT u
            FROM AppBundle:UserSeeker u
            LEFT JOIN u.skills sk
            WHERE sk.title LIKE :title
            ')
            ->setParameter('title', '%' . $title . '%');

        return $query->getResult();
    }
}
