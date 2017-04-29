<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Requirement;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class RequirementController
 * @package AppBundle\Controller
 * @Route("reikalavimai")
 */
class RequirementController extends Controller
{
    /**
     * @Route("/{{id}}",
     *     defaults = { "page" = 1 },
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
