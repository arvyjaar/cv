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
     * @Route("/skelbimai", name="index_ads")
     */
    public function indexAdsAction() {
        return $this->render('ads/index.html.twig');
    }

    /**
     * @Route("/iesko-darbo", name="index_seekers")
     */
    public function indexSeekersAction() {
        return $this->render('seekers/index.html.twig');
    }
}
