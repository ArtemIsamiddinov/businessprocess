<?php

namespace Demai\BusinessProcess;

use Demai\BusinessProcess\Entity\EntityInterface;
use Override;

class NullStateValidator implements StateValidatorInterface
{
    #[Override]
    public function validate(EntityInterface $entity): bool|string
    {
        return true;
    }
}