<?php

declare(strict_types=1);

namespace Meetup\Factory;

use Meetup\Bootstrap\Component;
use Meetup\Controller\ShowController;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;
use Meetup\Entity\Meetup;

final class ShowControllerFactory
{
    public function __invoke(ContainerInterface $container) : ShowController
    {
        $entityManager = $container->get(EntityManager::class);
        $meetupRepository = $container->get(EntityManager::class)->getRepository(Meetup::class);
        $bootstrapComponent = $container->get(Component::class);

        return new ShowController($entityManager, $meetupRepository, $bootstrapComponent);
    }
}
