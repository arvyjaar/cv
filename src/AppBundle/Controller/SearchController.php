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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Search controller.
 *
 * @Route("paieska")
 */
class SearchController extends Controller
{
    /**
     * @Route("/darbdaviai", name="searchEmployers")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchEmployerAction(Request $request)
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
                    ->setParameter('title', '%' . $key['title'] . '%');
            }
            if ($key['sector']) {
                $qb->andWhere('emp.sector = :sector')
                    ->setParameter('sector', $key['sector']);
            }

            $employers = $qb->getQuery()->getResult();

            return $this->render('useremployer/index.html.twig', array(
                'userEmployers' => $employers,
                //'form' => $form->createView(),
            ));
        }

        return $this->render('useremployer/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function searchEmployersFormAction()
    {
        $form = $this->createForm('AppBundle\Form\Type\EmployerSearchType', null, [
            'action' => $this->generateUrl('searchEmployers'),
        ]);
        return $this->render('search-employers.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/skelbimai", name="searchAds")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAdsAction(Request $request)
    {
        if (! $this->isCsrfTokenValid('searchAds', $request->get('_token'))) {
            throw new AccessDeniedException();
        }
        $repository = $this->getDoctrine()->getRepository('AppBundle:JobAd');
        $qb = $repository->createQueryBuilder('ja');
        $qb->select('ja');

        if ($request->get('keyword')) {
            $qb->where('ja.title LIKE :keyword')
                ->setParameter('keyword', '%' . $request->get('keyword') . '%');
        }
        $jobAds = $qb->getQuery()->getResult();

        return $this->render('jobad/index.html.twig', array(
            'jobAds' => $jobAds,
            'searchPath' => 'searchAds',
            'keyword' => $request->get('keyword'),
        ));
    }

    /**
     * @Route("/skelbimai/mano", name="searchMyAds")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchMyAdsAction(Request $request)
    {
        if (! $this->isCsrfTokenValid('searchAds', $request->get('_token'))) {
            throw new AccessDeniedException();
        }
        $repository = $this->getDoctrine()->getRepository('AppBundle:JobAd');
        $qb = $repository->createQueryBuilder('ja');
        $qb->select('ja')
            ->where('ja.employer = :employer')
            ->setParameter('employer', $this->getUser());

        if ($request->get('keyword')) {
            $qb->andWhere('ja.title LIKE :keyword')
                ->setParameter('keyword', '%' . $request->get('keyword') . '%');
        }
        $jobAds = $qb->getQuery()->getResult();

        return $this->render('jobad/my_index.html.twig', array(
            'jobAds' => $jobAds,
            'searchPath' => 'searchMyAds',
            'keyword' => $request->get('keyword'),
        ));
    }
}
