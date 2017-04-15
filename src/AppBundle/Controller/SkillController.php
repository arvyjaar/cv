<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Skill;
use Symfony\Component\HttpFoundation\JsonResponse;

class SkillController extends Controller
{

    /**
     * @Route("/skill/create",
     *     defaults = { "page" = 1 },
     *     options = { "expose" = true },
     *     name = "add_skill",
     * )
     */
    public function createAction(Request $request) {

        $skillTitle = $request->request->get('skill');
        $userID = (integer)$request->request->get('user-id');

        $repository = $this->getDoctrine()->getRepository('AppBundle:UserSeeker');
        $user = $repository->find($userID);

        $skill = new Skill();
        $skill->setTitle($skillTitle);
        $skill->setUser($user);

        $em = $this->getDoctrine()->getManager();
        $em->persist($skill);
        $em->flush();

        // Gets last insert ID
        $id = $skill->getId();

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
     *     name = "delete_skill",
     * )
     */
    public function deleteAction(Request $request, Skill $skill)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($skill);
        $em->flush();

        return new JsonResponse();
    }


}
