<?php
/**
 * Created by PhpStorm.
 * User: arvydas
 * Date: 4/14/17
 * Time: 8:39 PM
 */

namespace AppBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;

class RegistrationConfirmSubscriber implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationConfirm'
        );
    }

    public function onRegistrationConfirm(FormEvent $event)
    {
        $role = $title = $event->getRequest()->get('role');
        $url = (isset($role) && $role === 'ROLE_USER_EMPLOYER')
            ? $this->router->generate('user_seeker_index') : $this->router->generate('jobad_index');
        $event->setResponse(new RedirectResponse($url));
    }
}
