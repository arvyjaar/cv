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
use Symfony\Component\Form\Form;

/**
 * Jobapply controller.
 *
 * @Route("kandidatuoti")
 */
class JobApplyController extends Controller
{
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
        $form = $this->createForm(JobApply::class, $jobApply);
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

        return $this->render('jobapply/new.html.twig', [
            'jobApply' => $jobApply,
            'form' => $form->createView(),
        ]);
    }

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
     * @return Form The form
     */
    private function createDeleteForm(JobApply $jobApply)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jobapply_delete', ['id' => $jobApply->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }
}
