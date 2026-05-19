<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\State;

use Demai\BusinessProcess\NullStateValidator;
use Demai\BusinessProcess\StateValidatorInterface;
use Override;

/**
 * Класс состояния, который может быть использован вместо null.
 * Реализует паттерн Null Object.
 *
 * @package Demai\BusinessProcess\State
 * @author Artem Isamiddinov <artemisamiddinov@gmail.com>
 * @version 1.0.0
 */
class NullState extends BaseState
{
    /**
     * Конструктор, в котором происходит присваивание валидатора для текущего состояния.
     */
    public function __construct()
    {
        $this->setValidator(new NullStateValidator());
    }

    /**
     * {@inheritDoc}
     *
     * @return array Возвращает пустой массив, так как служит базовой реализацией Null Object.
     */
    #[Override]
    public function getNext(): array
    {
        return [];
    }
}
