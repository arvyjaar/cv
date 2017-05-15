<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Requirement;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("reikalavimai")
 */
class RequirementController extends Controller
{
    /**
     * @param Requirement $requirement
     *
     * @Route("/{id}",
     *     options = { "expose" = true },
     *     name = "delete_requirement",
     * )
     */
    public function deleteAction(Requirement $requirement)
    {
        $user = $this->getUser();
        if (! $user || ! $user->hasRole('ROLE_USER_EMPLOYER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($requirement);
        $em->flush();
    }
}
