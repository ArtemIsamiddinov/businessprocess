<?php

declare(strict_types=1);

namespace Demai\BusinessProcess;

use Demai\BusinessProcess\Entity;

/**
 * Интерфейс валидатора перехода на стадию для сущности
 */
interface StateValidatorInterface
{
    /**
     * Выполнить валидацю
     */
    public function validate(Entity\EntityInterface $entity): bool|string;
}
