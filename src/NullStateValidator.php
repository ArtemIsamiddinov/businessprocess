<?php

declare(strict_types=1);

namespace Demai\BusinessProcess;

use Demai\BusinessProcess\Entity\EntityInterface;
use Override;

/**
 * Класс валидатора, который может быть использован вместо null.
 * Реализует паттерн Null Object.
 *
 * @package Demai\BusinessProcess
 * @author Artem Isamiddinov <artemisamiddinov@gmail.com>
 * @version 1.0.0
 */
class NullStateValidator implements StateValidatorInterface
{
    /**
     * {@inheritDoc}
     *
     * @return bool|string Реализуется паттерн Null Object, результат всегда будет - true.
     */
    #[Override]
    public function validate(EntityInterface $entity): bool|string
    {
        return true;
    }
}
