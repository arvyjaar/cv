<?php

namespace Tests\App\Helper;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class LogInHelper
{
    public static function logInFakeAdmin(Client $client)
    {
        static::performLogIn($client, 'adminUser', [User::ROLE_ADMIN]);
    }

    public static function logInAdmin(Client $client)
    {
        static::logInUser($client, 'admin@admin');
    }

    public static function logInUser(Client $client, $email)
    {
        $user = $client->getContainer()->get('doctrine.orm.default_entity_manager')->getRepository('AppBundle:User')
            ->findOneBy(['email' => $email]);

        static::performUserLogIn($client, $user);
    }

    private static function performLogIn(Client $client, $user, $roles)
    {
        $session = $client->getContainer()->get('session');

        $firewall = 'main';
        $token = new UsernamePasswordToken($user, null, $firewall, $roles);
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    private static function performUserLogIn(Client $client, User $user)
    {
        static::performLogIn($client, $user, $user->getRoles());
    }
}
