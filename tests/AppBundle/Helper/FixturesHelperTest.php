<?php

namespace Tests\AppBundle\Helper;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FixturesHelperTest
{
    /**
     * @param ContainerInterface $container
     * @param array $fixtures
     */
    public static function loadFixtures(ContainerInterface $container, $fixtures = [])
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get('doctrine.orm.default_entity_manager');

        $schemaTool = new SchemaTool($entityManager);
        $metadata = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);

        $fixtureExecutor = new ORMExecutor($entityManager);
        $fixtureLoader = new ContainerAwareLoader($container);

        foreach ($fixtures as $fixture) {
            if (!$fixture instanceof FixtureInterface) {
                throw new \InvalidArgumentException(__METHOD__ . ' accepts FixtureInterfaces only');
            }
            $fixtureLoader->addFixture($fixture);
        }
        $fixtureExecutor->execute($fixtureLoader->getFixtures(), true);
    }
}
