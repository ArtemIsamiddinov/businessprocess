<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\State;

use Demai\BusinessProcess\StateValidatorInterface;
use Override;

/**
 * Абстрактный класс состояния, с базовой реализацией методов.
 *
 * @package Demai\BusinessProcess\State
 * @author Artem Isamiddinov <artemisamiddinov@gmail.com>
 * @version 1.0.0
 */
abstract class BaseState implements StateInterface
{
    /**
     * @var StateValidatorInterface Валидатор состояния.
     */
    protected StateValidatorInterface $validator;

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function getValidator(): StateValidatorInterface
    {
        return $this->validator;
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function setValidator(StateValidatorInterface $validator): StateInterface
    {
        $this->validator = $validator;
        return $this;
    }
}
