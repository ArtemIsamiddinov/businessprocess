<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\Entity;

use Demai\BusinessProcess\State\StateInterface;
use Override;

abstract class BaseEntity implements EntityInterface
{
    protected StateInterface $state;

    #[Override]
    public function getState(): StateInterface
    {
        return $this->state;
    }

    #[Override]
    public function setState(StateInterface $state): bool|string
    {
        $this->state = $state;
        return true;
    }
}
