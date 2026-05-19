<?php

declare(strict_types=1);

namespace Demai\BusinessProcess;

use Demai\BusinessProcess\Entity\EntityInterface;

/**
 * Интерфейс валидатора, который используется в состоянии.
 * Валидатор проверяет возможность перехода сущности в состояние, для которого указан текущий валидатор.
 *
 * @package Demai\BusinessProcess
 * @author Artem Isamiddinov <artemisamiddinov@gmail.com>
 * @version 1.0.0
 */
interface StateValidatorInterface
{
    /**
     * Выполнить валидацию сущности.
     *
     * @param EntityInterface $entity Сущность, которая будет проверяться.
     * @return bool|string В случае если сущность прошла проверку успешно - true, иначе сообщение об ошибке валидации.
     */
    public function validate(EntityInterface $entity): bool|string;
}
