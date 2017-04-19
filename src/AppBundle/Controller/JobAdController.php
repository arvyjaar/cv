<?php

namespace AppBundle\Controller;

use AppBundle\Entity\JobAd;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
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
     *
     * @Route("/", name="jobad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        // TODO: make pagination
        $jobAds = $em->getRepository('AppBundle:JobAd')->findAll();

        return $this->render('jobad/index.html.twig', array(
            'jobAds' => $jobAds,
        ));
    }

    /**
     * List all my jobAd entities.
     *
     * @Route("/mano-skelbimai", name="jobad_my_index")
     * @Method("GET")
     */
    public function indexMyAdsAction()
    {
        $em = $this->getDoctrine()->getManager();

        // TODO: make pagination
        $jobAds = $em->getRepository('AppBundle:JobAd')->findBy(
            ['employer' => $this->getUser()]
        );

        return $this->render('jobad/index.html.twig', array(
            'jobAds' => $jobAds,
        ));
    }

    /**
     * Creates a new jobAd entity.
     *
     * @Route("/naujas", name="jobad_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if (! $this->getUser()->hasRole('ROLE_USER_EMPLOYER'))
            throw new AccessDeniedException();

        $jobAd = new Jobad();
        $form = $this->createForm('AppBundle\Form\Type\JobAdType', $jobAd);
        $form->handleRequest($request);

        // Add employer_id
        $employer = $this->getUser();
        $jobAd->setOwner($employer);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jobAd);
            $em->flush();

            return $this->redirectToRoute('jobad_show', array('id' => $jobAd->getId()));
        }

        return $this->render('jobad/edit.html.twig', array(
            'jobAd' => $jobAd,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a jobAd entity.
     *
     * @Route("/{id}", name="jobad_show")
     * @Method("GET")
     */
    public function showAction(JobAd $jobAd)
    {
        $deleteForm = $this->createDeleteForm($jobAd);

        return $this->render('jobad/show.html.twig', array(
            'jobAd' => $jobAd,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing jobAd entity.
     *
     * @Route("/{id}/edit", name="jobad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, JobAd $jobAd)
    {
        $this->denyAccessUnlessGranted('edit', $jobAd);

        $deleteForm = $this->createDeleteForm($jobAd);
        $form = $this->createForm('AppBundle\Form\Type\JobAdType', $jobAd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jobad_edit', array('id' => $jobAd->getId()));
        }

        return $this->render('jobad/edit.html.twig', array(
            'jobAd' => $jobAd,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a jobAd entity. TODO: I think, we shouldn't delete jobAds. We should write 'Valid To' instead.
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
     *
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
}
