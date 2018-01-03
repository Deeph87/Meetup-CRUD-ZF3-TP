<?php

declare(strict_types=1);

namespace Meetup\Factory;

use Meetup\Controller\WriteController;
use Meetup\Entity\Meetup;
use Meetup\Form\MeetupForm;
use Meetup\Bootstrap\Component;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

final class WriteControllerFactory
{
    public function __invoke(ContainerInterface $container) : WriteController
    {
        $entityManager = $container->get(EntityManager::class);
        $meetupEntity = $container->get(Meetup::class);
        $meetupRepository = $container->get(EntityManager::class)->getRepository(Meetup::class);
        $meetupForm = $container->get(MeetupForm::class);
        $bootstrapComponent = $container->get(Component::class);

        return new WriteController($entityManager, $meetupEntity, $meetupRepository, $meetupForm, $bootstrapComponent);
    }
}
