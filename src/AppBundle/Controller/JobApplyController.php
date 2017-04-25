<?php

namespace AppBundle\Controller;

use AppBundle\Entity\JobAd;
use AppBundle\Entity\JobApply;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Jobapply controller.
 *
 * @Route("kandidatuoti")
 */
class JobApplyController extends Controller
{
//    /**
//     * Lists all jobApply entities.
//     *
//     * @Route("/", name="jobapply_index")
//     * @Method("GET")
//     */
//    public function indexAction()
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $jobApplies = $em->getRepository('AppBundle:JobApply')->findAll();
//
//        return $this->render('jobapply/index.html.twig', array(
//            'jobApplies' => $jobApplies,
//        ));
//    }

    /**
     * Creates a new jobApply entity.
     *
     * @Route("/{ad_id}/new", name="jobapply_new")
     * @Method({"GET", "POST"})
     * @ParamConverter("jobad", class="AppBundle:JobAd", options={"id" = "ad_id"})
     */
    public function newAction(JobAd $jobad, Request $request)
    {
        if (! $this->getUser()->hasRole('ROLE_USER_SEEKER')) {
            throw new AccessDeniedException();
        }

        $jobApply = new Jobapply();
        $form = $this->createForm('AppBundle\Form\Type\JobApplyType', $jobApply);
        $form->handleRequest($request);

        // Add UserSeeker, add JobAd
        $seeker = $this->getUser();
        $jobApply->setOwner($seeker);
        $jobApply->setJobAd($jobad);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jobApply);
            $em->flush();

            return $this->redirectToRoute('jobad_index');
        }

        return $this->render('jobapply/new.html.twig', array(
            'jobApply' => $jobApply,
            'form' => $form->createView(),
        ));
    }

//    /**
//     * Finds and displays a jobApply entity.
//     *
//     * @Route("/{id}", name="jobapply_show")
//     * @Method("GET")
//     */
//    public function showAction(JobApply $jobApply)
//    {
//        $deleteForm = $this->createDeleteForm($jobApply);
//
//        return $this->render('jobapply/index.html.twig', array(
//            'jobApply' => $jobApply,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

//    /**
//     * Displays a form to edit an existing jobApply entity.
//     *
//     * @Route("/{id}/edit", name="jobapply_edit")
//     * @Method({"GET", "POST"})
//     */
//    public function editAction(Request $request, JobApply $jobApply)
//    {
//        $this->denyAccessUnlessGranted('edit', $jobApply);
//
//        $deleteForm = $this->createDeleteForm($jobApply);
//        $form = $this->createForm('AppBundle\Form\Type\JobApplyType', $jobApply);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('jobapply_edit', array('id' => $jobApply->getId()));
//        }
//
//        return $this->render('jobapply/new.html.twig', array(
//            'jobApply' => $jobApply,
//            'edit_form' => $form->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Deletes a jobApply entity.
     *
     * @Route("/{id}", name="jobapply_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, JobApply $jobApply)
    {
        $this->denyAccessUnlessGranted('edit', $jobApply);

        $form = $this->createDeleteForm($jobApply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($jobApply);
            $em->flush();
        }

        return $this->redirectToRoute('jobapply_index');
    }

    /**
     * Creates a form to delete a jobApply entity.
     *
     * @param JobApply $jobApply The jobApply entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(JobApply $jobApply)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jobapply_delete', array('id' => $jobApply->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
