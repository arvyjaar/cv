<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;;
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
     * @Route("/naujas",
     *     defaults = { "page" = 1 },
     *     options = { "expose" = true },
     *     name = "add_requirement",
     * )
     */
    public function createAction(Request $request) {

        $requirementTitle = $request->request->get('requirement');
        $adID = (integer)$request->request->get('ad-id');

        $repository = $this->getDoctrine()->getRepository('AppBundle:JobAd');
        $jobAd = $repository->find($adID);

        $requirement = new Requirement();
        $requirement->setTitle($requirementTitle);
        $requirement->setJobAd($jobAd);

        $em = $this->getDoctrine()->getManager();
        $em->persist($requirement);
        $em->flush();

        // Gets last insert ID
        $id = $requirement->getId();

        // Sends last insert id to main.js class
        $response = new JsonResponse();
        $response->setData(array(
            'id' => $id
        ));

        return $response;
    }

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
