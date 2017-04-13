<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Skill;
use Symfony\Component\HttpFoundation\JsonResponse;

class SkillsControllerController extends Controller
{

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

        return new JsonResponse('success');
    }

}
