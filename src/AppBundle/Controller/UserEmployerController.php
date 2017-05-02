<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserEmployer;
use AppBundle\Entity\UserSeeker;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Validator\Constraints\DateTime;
use Psr\Cache\CacheItemPoolInterface;

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
        $legalEntitysCode = $userEmployer->getlegalEntitysCode();

        $salary = $this->getSalary($legalEntitysCode);

        return $this->render('useremployer/show.html.twig', array(
            'userEmployer' => $userEmployer,
            'salary' => $salary,
        ));
    }

    public function getSalary($legalEntitysCode)
    {
        $cache = new FilesystemAdapter();
        $cachedValues = $cache->getItem($legalEntitysCode);

        if ($cachedValues->isHit()) {
            $cachedData = $cachedValues->get();
            $salary = $cachedData[$legalEntitysCode];
        } else {
            $salary = $this->get('app.salary_crawler')->fetchSalary($legalEntitysCode);

            $cachedValues->set(array(
                $legalEntitysCode => $salary,
            ));

            $firstDayOfNextMonth = date_modify(new \DateTime('now'), 'first day of +1 month 00:00:00');
            $cachedValues->expiresAt($firstDayOfNextMonth);
            $cache->save($cachedValues);
        }

        return $salary;
    }
}
