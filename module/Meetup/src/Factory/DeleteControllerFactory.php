<?php

declare(strict_types=1);

namespace Meetup\Factory;

use Meetup\Bootstrap\Component;
use Meetup\Controller\DeleteController;
use Psr\Container\ContainerInterface;
use Doctrine\ORM\EntityManager;

final class DeleteControllerFactory
{
    public function __invoke(ContainerInterface $container) : DeleteController
    {
        $entityManager = $container->get(EntityManager::class);
        $bootstrapComponent = $container->get(Component::class);

        return new DeleteController($entityManager, $bootstrapComponent);
    }
}
