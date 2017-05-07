<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserSeeker;
use AppBundle\Form\Type\AdsSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Userseeker controller.
 * Lists all UserSeekers, shows individual UserSeeker profile for everyone
 *
 * @Route("iesko-darbo")
 */
class UserSeekerController extends Controller
{
    /**
     * Lists all userSeeker entities.
     * @param Request $request
     * @return Response
     * @Route("/", name="user_seeker_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(AdsSearchType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository = $this->getDoctrine()->getRepository(UserSeeker::class);
            $userSeekers = $repository->findSeekers($request->get('title'));
        } else {
            $userSeekers = $this->getDoctrine()->getRepository(UserSeeker::class)->findAll();
        }

        return $this->render('userseeker/index.html.twig', [
            'userSeekers' => $userSeekers,
            'searchForm' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a userSeeker entity.
     * @param UserSeeker $userSeeker
     *
     * @return Response
     * @Route("/{id}", name="user_seeker_show")
     * @Method("GET")
     */
    public function showAction(UserSeeker $userSeeker)
    {
        return $this->render('userseeker/show.html.twig', [
            'userSeeker' => $userSeeker,
        ]);
    }
}
