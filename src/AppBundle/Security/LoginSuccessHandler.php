<?php
/**
 * Created by PhpStorm.
 * User: arvydas
 * Date: 4/12/17
 * Time: 8:30 PM
 */

namespace AppBundle\Security;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected $router;
    protected $authorizationChecker;

    public function __construct(Router $router, AuthorizationChecker $authorizationChecker)
    {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {

        $response = null;

        if ($this->authorizationChecker->isGranted('ROLE_USER_SEEKER')) {
            $response = new RedirectResponse($this->router->generate('jobad_index'));
        } else {
            if ($this->authorizationChecker->isGranted('ROLE_USER_EMPLOYER')) {
                $response = new RedirectResponse($this->router->generate('user_seeker_index'));
            }
        }

        return $response;
    }
}
