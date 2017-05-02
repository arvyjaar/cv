<?php
namespace AppBundle\Controller;

use AppBundle\Entity\JobAd;
use AppBundle\Form\Type\JobAdType;
use AppBundle\Entity\UserEmployer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Entity\Requirement;
use Symfony\Component\Form\Form;

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
        return $this->render('jobad/index.html.twig', [
            'jobAds' => $jobAds,
        ]);
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
        return $this->render('jobad/my_index.html.twig', [
            'jobAds' => $jobAds,
        ]);
    }

    /**
     * List all jobAd entities of Employer.
     *
     * @Route("/imone/{id}", name="jobad_by_employer_index")
     * @Method("GET")
     */
    public function indexEmployerAdsAction(UserEmployer $employer)
    {
        $em = $this->getDoctrine()->getManager();
        // TODO: make pagination
        $jobAds = $em->getRepository('AppBundle:JobAd')->findBy(
            ['employer' => $employer]
        );
        return $this->render('jobad/index.html.twig', [
            'jobAds' => $jobAds,
            'employer' => $employer,
        ]);
    }

    /**
     * Creates a new jobAd entity.
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
        return $this->render('jobad/new.html.twig', [
            'jobAd' => $jobAd,
            'form' => $form->createView(),
        ]);
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
        return $this->render('jobad/show.html.twig', [
            'jobAd' => $jobAd,
            'deleteForm' => $deleteForm->createView(),
        ]);
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

            return $this->redirectToRoute('jobad_show', ['id' => $jobAd->getId()]);
        }
        return $this->render('jobad/new.html.twig', [
            'jobAd' => $jobAd,
            'form' => $form->createView(),
            'deleteForm' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a jobAd entity.
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
     * @return Form The form
     */
    private function createDeleteForm(JobAd $jobAd)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jobad_delete', ['id' => $jobAd->getId()]))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Saves JobAd Requirements to db
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
