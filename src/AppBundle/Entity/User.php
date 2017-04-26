<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"user_employer" = "UserEmployer", "user_seeker" = "UserSeeker"})
 *
 */
abstract class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    protected $id;

    public function setEmail($email)
    {
        parent::setEmail($email);
        parent::setUsername($email);
    }

    public function getRoles()
    {
        parent::getRoles();

        if ($this instanceof UserSeeker) {
            return ['ROLE_USER_SEEKER'];
        } elseif ($this instanceof UserEmployer) {
            return ['ROLE_USER_EMPLOYER'];
        } else {
            return ['ROLE_DEFAULT'];
        }
    }
}
