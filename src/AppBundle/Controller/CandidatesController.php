<?php
/**
 * Created by arvydas.
 * Date: 4/23/17 - Time: 1:58 PM
 */

namespace AppBundle\Controller;

use AppBundle\Entity\JobAd;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class CandidatesController
 * @package AppBundle\Controller
 * @Route("skelbimas/kandidatavo")
 */
class CandidatesController extends Controller
{

    /**
     * Lists of candidates to JobAd (jobApply entities).
     *
     * @Route("/{id}", name="jobapply_index")
     * @Method("GET")
     *
     */
    public function indexAction(JobAd $jobAd)
    {
        $this->denyAccessUnlessGranted('edit', $jobAd);

        $em = $this->getDoctrine()->getManager();

        // TODO: make pagination
        $jobApplies = $em->getRepository('AppBundle:JobApply')->findBy(
            ['jobAd' => $jobAd]
        );

        return $this->render('jobapply/index.html.twig', array(
            'jobAd' => $jobAd,
            'jobApplies' => $jobApplies,
        ));
    }
}
