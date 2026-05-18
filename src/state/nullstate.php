<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\State;

use Demai\BusinessProcess\NullStateValidator;
use Demai\BusinessProcess\StateValidatorInterface;
use Override;

/**
 * Статус для использования вместо null
 */
class NullState extends BaseState
{
    protected StateValidatorInterface $validator;

    public function __construct()
    {
        $this->setValidator(new NullStateValidator());
    }

    #[Override]
    public function getNext(): array
    {
        return [];
    }
}
