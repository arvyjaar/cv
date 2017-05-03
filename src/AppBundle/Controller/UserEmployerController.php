<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserEmployer;
use AppBundle\Form\Type\EmployerSearchType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Provider\AverageSalaryProvider;
use Symfony\Component\HttpFoundation\Response;
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
     * @param Request $request
     * @return Response
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
            $userEmployers = $this->getDoctrine()->getRepository(UserEmployer::class)->findAll();
        }

        return $this->render('useremployer/index.html.twig', array(
            'userEmployers' => $userEmployers,
            'searchForm' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userEmployer entity.
     *
     * @param UserEmployer $userEmployer
     * @return Response
     * @Route("/{id}", name="user_employer_show")
     * @Method("GET")
     */
    public function showAction(UserEmployer $userEmployer)
    {
        $legalEntitysCode = $userEmployer->getlegalEntitysCode();

        //TODO refactor this method
        $salaryProvider = new AverageSalaryProvider($this->container->get('app.salary_crawler'));
        $salary = $salaryProvider->getSalary($legalEntitysCode);

        return $this->render('useremployer/show.html.twig', [
            'userEmployer' => $userEmployer,
            'salary' => $salary,
        ]);
    }
}
