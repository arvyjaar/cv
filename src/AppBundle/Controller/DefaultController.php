<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ProfileUserSeekerFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    // TODO: move actions to appropriate controller

    /**
     * @Route("/iesko-darbo", name="seeker_index")
     */
    public function indexSeekersAction() {
        return $this->render('seekers/index.html.twig');
    }
}
