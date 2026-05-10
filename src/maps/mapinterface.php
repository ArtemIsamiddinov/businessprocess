<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\Maps;

interface MapInterface
{
    public function getNext() : ?MapInterface;

    public function getPrimary() : mixed;
}