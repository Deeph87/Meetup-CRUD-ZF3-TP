<?php

declare(strict_types=1);

namespace Meetup\Factory;

use Meetup\Form\MeetupForm;
use Psr\Container\ContainerInterface;

final class MeetupFormFactory
{
    public function __invoke(ContainerInterface $container) : MeetupForm
    {
        $dateTime = $container->get(\DateTimeImmutable::class);

        return new MeetupForm($dateTime);
    }
}
