<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\State;

use Demai\BusinessProcess\State\StateInterface;
use Demai\BusinessProcess\StateValidatorInterface;
use Override;

abstract class BaseState implements StateInterface
{
    protected StateValidatorInterface $validator;
    
    #[Override]
    public function getValidator(): StateValidatorInterface
    {
        return $this->validator;
    }

    #[Override]
    public function setValidator(StateValidatorInterface $validator): StateInterface
    {
        $this->validator = $validator;
        return $this;
    }
}