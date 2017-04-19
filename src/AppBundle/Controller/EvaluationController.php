<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evaluation;
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
     * @Route("/naujas", name="evaluation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        if (! $this->getUser()->hasRole('ROLE_USER_EMPLOYER'))
            throw new AccessDeniedException();

        $evaluation = new Evaluation();
        $form = $this->createForm('AppBundle\Form\Type\EvaluationType', $evaluation);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evaluation);
            $em->flush();

            return $this->redirectToRoute('evaluation_edit', array('id' => $evaluation->getId()));
        }

        return $this->render('evaluation/edit.html.twig', array(
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

        $deleteForm = $this->createDeleteForm($evaluation);
        $form = $this->createForm('AppBundle\Form\Type\EvaluationType', $evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evaluation_edit', array('id' => $evaluation->getId()));
        }

        return $this->render('evaluation/edit.html.twig', array(
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
        $this->denyAccessUnlessGranted('edit', $evaluation);

        $form = $this->createDeleteForm($evaluation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evaluation);
            $em->flush();
        }

        return $this->redirectToRoute('jobad_index');
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
