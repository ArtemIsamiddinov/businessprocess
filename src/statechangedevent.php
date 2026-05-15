<?php

declare(strict_types=1);

namespace Demai\BusinessProcess;

use Demai\BusinessProcess\Entity\EntityInterface;
use Demai\BusinessProcess\State\StateInterface;

/**
 * Событие, после успешного перехода по статусам
 */
final class StateChangedEvent
{
    public function __construct(
        public readonly EntityInterface $entity,
        public readonly StateInterface $fromState,
        public readonly StateInterface $toState,
        public readonly mixed $context = null
    ) {}
}
