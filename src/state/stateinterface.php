<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\State;

use Demai\BusinessProcess\StateValidatorInterface;

interface StateInterface
{
    public function getNext(): array;

    public function getValidator(): StateValidatorInterface;

    public function setValidator(StateValidatorInterface $validator): StateInterface;
}
