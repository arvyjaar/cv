<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserEmployer;
use AppBundle\Form\Type\EmployerSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/", name="user_employer_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(EmployerSearchType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository = $this->getDoctrine()->getRepository(UserEmployer::class);
            $userEmployers = $repository->searchEmployers($request->get('title'), $request->get('sector'));
        } else {
            $userEmployers = $this->getDoctrine()->getRepository('AppBundle:UserEmployer')->findAll();
        }

        return $this->render('useremployer/index.html.twig', array(
            'userEmployers' => $userEmployers,
            'searchForm' => $form->createView(),
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
