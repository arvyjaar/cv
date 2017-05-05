<?php

namespace AppBundle\Controller;

use AppBundle\Entity\JobAd;
use AppBundle\Entity\Requirement;
use AppBundle\Entity\UserEmployer;
use AppBundle\Form\Type\JobAdType;
use AppBundle\Form\Type\AdsSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Jobad controller.
 *
 * @Route("skelbimai")
 */
class JobAdController extends Controller
{
    /**
     * Lists all jobAd entities.
     * @param Request $request
     *
     * @return Response
     * @Route("/", name="jobad_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(AdsSearchType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository = $this->getDoctrine()->getRepository(JobAd::class);
            $jobAds = $repository->searchAds($request->get('title'));
        } else {
            $jobAds = $this->getDoctrine()->getRepository(JobAd::class)->findAll();
        }

        return $this->render('jobad/index.html.twig', array(
            'jobAds' => $jobAds,
            'searchForm' => $form->createView(),
        ));
    }

    /**
     * List all my jobAd entities.
     * @param Request $request
     *
     * @return Response
     * @Route("/mano-skelbimai", name="jobad_my_index")
     * @Method("GET")
     */
    public function indexMyAdsAction(Request $request)
    {
        $form = $this->createForm(AdsSearchType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository = $this->getDoctrine()->getRepository(JobAd::class);
            $jobAds = $repository->searchMyAds($request->get('title'), $this->getUser());
        } else {
            $jobAds = $this->getDoctrine()->getRepository(JobAd::class)->findBy(
                ['employer' => $this->getUser()]
            );
        }

        return $this->render('jobad/my_index.html.twig', array(
            'jobAds' => $jobAds,
            'searchForm' => $form->createView(),
        ));
    }

    /**
     * List all jobAd entities of Employer.
     * @param UserEmployer $employer
     * @param Request $request
     *
     * @return Response
     * @Route("/imone/{id}", name="jobad_by_employer_index")
     * @Method("GET")
     */
    public function indexEmployerAdsAction(UserEmployer $employer, Request $request)
    {
        $form = $this->createForm(AdsSearchType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository = $this->getDoctrine()->getRepository(JobAd::class);
            $jobAds = $repository->searchMyAds($request->get('title'), $employer);
        } else {
            $jobAds = $this->getDoctrine()->getRepository(JobAd::class)->findBy(
                ['employer' => $employer]
            );
        }

        return $this->render('jobad/index.html.twig', array(
            'jobAds' => $jobAds,
            'employer' => $employer,
            'searchForm' => $form->createView(),
        ));
    }

    /**
     * Creates a new jobAd entity.
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/naujas",
     *     defaults = { "page" = 1 },
     *     options = { "expose" = true },
     *     name="jobad_new"
     * )
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if (! $this->getUser()->hasRole('ROLE_USER_EMPLOYER')) {
            throw new AccessDeniedException();
        }
        $jobAd = new Jobad();
        $form = $this->createForm(JobAdType::class, $jobAd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Save requirements and exclude it's value from jobAd entity
            $requirements = $form->get('requirements')->getData();

            $jobAd->setRequirements(null);

            $employer = $this->getUser();
            $jobAd->setOwner($employer);

            $em = $this->getDoctrine()->getManager();
            $em->persist($jobAd);
            $em->flush();

            if ($requirements) {
                $this->saveJobAdRequirements($requirements, $jobAd);
            }

            return $this->redirectToRoute('jobad_show', array('id' => $jobAd->getId()));
        }
        return $this->render('jobad/new.html.twig', array(
            'jobAd' => $jobAd,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a jobAd entity.
     * @Route("/{id}", name="jobad_show")
     * @Method("GET")
     */
    public function showAction(JobAd $jobAd)
    {
        $deleteForm = $this->createDeleteForm($jobAd);
        $user = $this->getUser();
        $hideButton = false;

        //Checks if user already applied
        if ($user->hasRole('ROLE_USER_SEEKER')) {
            $jobApplies = $user->getJobApply();
            foreach ($jobApplies as $jobApply) {
                $appliedJobAd = $jobApply->getJobAd();
                if ($appliedJobAd == $jobAd) {
                    $hideButton = true;
                }
            }
        }

        return $this->render('jobad/show.html.twig', array(
            'jobAd' => $jobAd,
            'hide' => $hideButton,
            'deleteForm' => $deleteForm->createView()
        ));
    }

    /**
     * Displays a form to edit an existing jobAd entity.
     * @param Request $request
     * @param JobAd $jobAd
     *
     * @return Response
     *
     * @Route("/{id}/edit", name="jobad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, JobAd $jobAd)
    {
        $this->denyAccessUnlessGranted('edit', $jobAd);

        $deleteForm = $this->createDeleteForm($jobAd);
        $form = $this->createForm(JobAdType::class, $jobAd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //Save requirements and exclude it's value from jobAd entity
            $requirements = $form->get('requirements')->getData();
            $jobAd->setRequirements(null);

            $this->getDoctrine()->getManager()->flush();

            if ($requirements) {
                $this->saveJobAdRequirements($requirements, $jobAd);
            }

            return $this->redirectToRoute('jobad_show', array('id' => $jobAd->getId()));
        }
        return $this->render('jobad/new.html.twig', array(
            'jobAd' => $jobAd,
            'form' => $form->createView(),
            'deleteForm' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a jobAd entity.
     * @param Request $request
     * @param JobAd $jobAd
     *
     * @return Response
     *
     * @Route("/{id}", name="jobad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, JobAd $jobAd)
    {
        $this->denyAccessUnlessGranted('edit', $jobAd);
        $form = $this->createDeleteForm($jobAd);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($jobAd);
            $em->flush();
        }
        return $this->redirectToRoute('jobad_index');
    }

    /**
     * Creates a form to delete a jobAd entity.
     * @param JobAd $jobAd The jobAd entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(JobAd $jobAd)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jobad_delete', array('id' => $jobAd->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Saves JobAd Requirements to db
     * @param string $requirements
     * @param JobAd $jobAd
     */
    public function saveJobAdRequirements($requirements, JobAd $jobAd)
    {
        $requirements = explode(',', $requirements);

        foreach ($requirements as $requirementTitle) {
            $requirement = new Requirement();
            $requirement->setTitle($requirementTitle);
            $requirement->setJobAd($jobAd);

            $em = $this->getDoctrine()->getManager();
            $em->persist($requirement);
            $em->flush();
        }
    }
}
