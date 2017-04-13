<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Skill;
use Symfony\Component\HttpFoundation\JsonResponse;

class SkillsControllerController extends Controller
{
    /**
     *@Route("/skill/create", name="add_skill")
     *
     */
    public function create(Request $request) {

        var_dump($request);
        die;

        $skill = new Skill();
        $skill->setTitle('php');

        $em = $this->getDoctrine()->getManager();
        $em->persist($skill);
        $em->flush();

        return new JsonResponse('success');

    }


}
