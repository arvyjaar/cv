<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserEmployer;
use AppBundle\Entity\UserSeeker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * UserEmployer controller.
 * Lists all UserEmployers, shows individual UserEmployer profile for everyone
 *
 * @Route("darbdaviai")
 */
class UserEmployerController extends Controller
{
    /**
     * Lists all userEmployer entities.
     *
     * @Route("/", name="user_employer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        // TODO: pagination

        $em = $this->getDoctrine()->getManager();

        $userEmployers = $em->getRepository('AppBundle:UserEmployer')->findAll();

        return $this->render('useremployer/index.html.twig', array(
            'userEmployers' => $userEmployers,
        ));
    }

    /**
     * Finds and displays a userEmployer entity.
     *
     * @Route("/{id}", name="user_employer_show")
     * @Method("GET")
     */
    public function showAction(UserEmployer $userEmployer)
    {

        return $this->render('useremployer/show.html.twig', array(
            'userEmployer' => $userEmployer,
        ));
    }
}
