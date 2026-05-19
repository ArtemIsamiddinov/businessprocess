<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\State;

use Demai\BusinessProcess\StateValidatorInterface;

/**
 * Интерфейс состояния по которому будет следовать сущность в процессах.
 *
 * @package Demai\BusinessProcess\State
 * @author Artem Isamiddinov <artemisamiddinov@gmail.com>
 * @version 1.0.0
 */
interface StateInterface
{
    /**
     * Получить массив состояний, на которые сущность может перейти из текущего состояния.
     *
     * @return StateInterface[] Массив состояний.
     */
    public function getNext(): array;

    /**
     * Получить валидатор состояния.
     *
     * @return StateValidatorInterface Валидатор состояния.
     */
    public function getValidator(): StateValidatorInterface;

    /**
     * Установить валидатор состояния.
     * Функция работает как chain, для того чтобы при расширении методов состояний можно было сокращать вызов методов.
     *
     * @param StateValidatorInterface $validator Валидатор, который будет установлен для текущего состояния.
     * @return StateInterface Текущее состояние.
     */
    public function setValidator(StateValidatorInterface $validator): StateInterface;
}
