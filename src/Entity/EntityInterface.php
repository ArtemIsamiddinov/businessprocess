<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\Entity;

use Demai\BusinessProcess\State\StateInterface;

/**
 * Интерфейс сущности которая обрабатывается в процессах.
 *
 * @package Demai\BusinessProcess\Entity
 * @author Artem Isamiddinov <artemisamiddinov@gmail.com>
 * @version 1.0.0
 */
interface EntityInterface
{
    /**
     * Получить текущее состояние сущности.
     *
     * @return StateInterface Текущее состояние сущности.
     */
    public function getState(): StateInterface;

    /**
     * Установить текущее состояние сущности.
     *
     * @param StateInterface $state Состояние сущности, которое необходимо установить.
     * @param mixed $context    Контекст перехода в новое состояние. Дополнительные данные,
     *                          которые можно использовать при переходе в новое состояние.
     * @return bool|string true в случае успеха, иначе сообщение об ошибке.
     */
    public function setState(StateInterface $state, mixed $context = null): bool|string;
}
