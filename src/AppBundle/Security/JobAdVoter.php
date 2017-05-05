<?php
/**
 * Created by PhpStorm.
 * User: arvydas
 * Date: 4/16/17
 * Time: 11:45 PM
 */

namespace AppBundle\Security;

use AppBundle\Entity\JobAd;
use AppBundle\Entity\User;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class JobAdVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (! in_array($attribute, array(self::VIEW, self::EDIT))) {
            return false;
        }

        // only vote on JobAd objects inside this voter
        if (! $subject instanceof JobAd) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (! $user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a JobAd object, thanks to supports
        /** @var JobAd $jobad */
        $jobad = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($jobad, $user);
            case self::EDIT:
                return $this->canEdit($jobad, $user);
        }

        throw new LogicException('This code should not be reached!');
    }

    private function canView(JobAd $jobad, User $user)
    {
        // if they can edit, they can view
        if ($this->canEdit($jobad, $user)) {
            return true;
        }

        // the JobAd object could have, for example, a method isPrivate()
        // that checks a boolean $private property
        // return !$jobad->isPrivate();
    }

    private function canEdit(JobAd $jobad, User $user)
    {
        // this assumes that the data object has a getOwner() method
        // to get the entity of the user who owns this data object
        return $user === $jobad->getOwner();
    }
}
