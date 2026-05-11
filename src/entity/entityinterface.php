<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\Entity;

use Demai\BusinessProcess\State\StateInterface;

interface EntityInterface
{
    public function getState() : StateInterface;

    public function setState(StateInterface $state) : bool|string;
}