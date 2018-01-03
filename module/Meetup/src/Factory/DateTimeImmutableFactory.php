<?php

declare(strict_types=1);

namespace Meetup\Factory;

use Psr\Container\ContainerInterface;

final class DateTimeImmutableFactory
{
    public function __invoke(ContainerInterface $container) : \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
