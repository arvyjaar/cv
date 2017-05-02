<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserEmployer;
use AppBundle\Entity\UserSeeker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Provider\AverageSalaryProvider;

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

        return $this->render('useremployer/index.html.twig', [
            'userEmployers' => $userEmployers,
        ]);
    }

    /**
     * Finds and displays a userEmployer entity.
     *
     * @Route("/{id}", name="user_employer_show")
     * @Method("GET")
     */
    public function showAction(UserEmployer $userEmployer)
    {
        $legalEntitysCode = $userEmployer->getlegalEntitysCode();

        //TODO refactor this method
        $salaryProvider = new AverageSalaryProvider();
        $salary = $salaryProvider->getSalary($legalEntitysCode);

        return $this->render('useremployer/show.html.twig', [
            'userEmployer' => $userEmployer,
            'salary' => $salary,
        ]);
    }
}
