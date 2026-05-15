<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\State;

use Demai\BusinessProcess\StateValidatorInterface;
use Override;

/**
 * Статус для использования вместо null
 */
class NullState extends BaseState
{
    protected StateValidatorInterface $validator;

    #[Override]
    public function getNext(): array
    {
        return [];
    }
}
