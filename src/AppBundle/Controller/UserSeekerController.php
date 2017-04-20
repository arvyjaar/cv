<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserSeeker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Userseeker controller.
 * Lists all UserSeekers, shows individual UserSeeker profile for everyone
 *
 * @Route("iesko-darbo")
 */
class UserSeekerController extends Controller
{
    /**
     * Lists all userSeeker entities.
     *
     * @Route("/", name="user_seeker_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        // TODO: pagination

        $em = $this->getDoctrine()->getManager();

        $userSeekers = $em->getRepository('AppBundle:UserSeeker')->findAll();

        return $this->render('userseeker/index.html.twig', array(
            'userSeekers' => $userSeekers,
        ));
    }

    /**
     * Finds and displays a userSeeker entity.
     *
     * @Route("/{id}", name="user_seeker_show")
     * @Method("GET")
     */
    public function showAction(UserSeeker $userSeeker)
    {

        return $this->render('userseeker/show.html.twig', array(
            'userSeeker' => $userSeeker,
        ));
    }
}
