<?php

declare(strict_types=1);

namespace Demai\BusinessProcess;

use Demai\BusinessProcess\Entity;

interface StateValidatorInterface
{
    public function validate(Entity\EntityInterface $entity): bool|string;
}
