<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Requirement;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("reikalavimai")
 */
class RequirementController extends Controller
{
    /**
     * @param Request $request
     * @param Requirement $requirement
     *
     * @return JsonResponse
     * @Route("/{id}",
     *     options = { "expose" = true },
     *     name = "delete_requirement",
     * )
     */
    public function deleteAction(Request $request, Requirement $requirement)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($requirement);
        $em->flush();

        return new JsonResponse();
    }
}
