<?php
/**
 * Created by arvydas.
 * Date: 4/29/17 - Time: 8:36 PM
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Search controller.
 *
 * @Route("paieska")
 */
class SearchController extends Controller
{
    /**
     * @Route("/darbdaviai", name="searchEmployers")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchEmployerFormAction(Request $request)
    {
        $key = $request->get('employer_search');

        $form = $this->createForm('AppBundle\Form\Type\EmployerSearchType', null, [
            'action' => $this->generateUrl('searchEmployers'),
            ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository = $this->getDoctrine()->getRepository('AppBundle:UserEmployer');
            $qb = $repository->createQueryBuilder('emp');
            $qb->select('emp');
            if ($key['title']) {
                $qb->where('emp.title LIKE :title')
                    ->setParameter('title', '%'.$key['title'].'%');
            }
            if ($key['sector']) {
                $qb->andWhere('emp.sector = :sector')
                    ->setParameter('sector', $key['sector']);
            }

            $employers = $qb->getQuery()->getResult();

            return $this->render('useremployer/index.html.twig', array(
                'userEmployers' => $employers,
                'form' => $form->createView(),
                'title' => $key['title'],
                'sector' => $key['sector']
            ));
        }

        return $this->render('search-employers.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
