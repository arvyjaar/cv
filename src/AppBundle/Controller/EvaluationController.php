<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evaluation;
use AppBundle\Entity\JobAd;
use AppBundle\Entity\JobApply;
use AppBundle\Entity\UserSeeker;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Evaluation controller.
 *
 * @Route("ivertinimas")
 */
class EvaluationController extends Controller
{

    /**
     * Creates a new Evaluation entity.
     *
     * @Route("/naujas/{apply_id}", name="evaluation_new")
     * @Method({"GET", "POST"})
     * @ParamConverter("jobApply", class="AppBundle:JobApply", options={"id" = "apply_id"})
     */

    public function newAction(JobApply $jobApply, Request $request)
    {
        // Only this JobAd author can write evaluation
        $jobAd = $jobApply->getJobAd();
        $this->denyAccessUnlessGranted('edit', $jobAd);
        // Only one evaluation for one jobApply
        if ($jobApply->getEvaluation() !== null) {
            throw  new AccessDeniedException();
        }

        $evaluation = new Evaluation();
        $form = $this->createForm('AppBundle\Form\Type\EvaluationType', $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evaluation);
            $em->flush();

            // Gets last insert ID

            $jobApply->setEvaluation($evaluation);
            $em->persist($jobApply);
            $em->flush();

            //return $this->redirectToRoute('evaluation_edit', array('id' => $evaluation->getId()));
            return $this->redirectToRoute('jobapply_index', ['id' => $jobAd->getId()]);
        }

        return $this->render('evaluation/new.html.twig', array(
            'jobApply' => $jobApply,
            'evaluation' => $evaluation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Evaluation entity.
     *
     * @Route("/{id}/edit", name="evaluation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Evaluation $evaluation)
    {
        // Only this JobAd author can edit evaluation
        $jobAd = $evaluation->getJobApply()->getJobAd();
        $this->denyAccessUnlessGranted('edit', $jobAd);

        $deleteForm = $this->createDeleteForm($evaluation);
        $form = $this->createForm('AppBundle\Form\Type\EvaluationType', $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('jobapply_index', ['id' => $jobAd->getId()]);
        }

        return $this->render('evaluation/new.html.twig', array(
            'jobApply' => $evaluation->getJobApply(),
            'evaluation' => $evaluation,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * !!! TURI GALIMYBĘ IŠTRINTI TIK SEEKERIS, KURIAM PRIKLAUSO SKELBIMAS!!!!!
     * Deletes a Evaluation entity.
     *
     * @Route("/{id}", name="evaluation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Evaluation $evaluation)
    {
        // Only this JobAd author can edit evaluation
        $jobAd = $evaluation->getJobApply()->getJobAd();
        $this->denyAccessUnlessGranted('edit', $jobAd);

        $form = $this->createDeleteForm($evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evaluation);
            $em->flush();
        }

        return $this->redirectToRoute('jobapply_index', ['id' => $jobAd->getId()]);
    }

    /**
     * Creates a form to delete a Evaluation entity.
     *
     * @param Evaluation $evaluation The Evaluation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Evaluation $evaluation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evaluation_delete', array('id' => $evaluation->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
