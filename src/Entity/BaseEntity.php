<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\Entity;

use Demai\BusinessProcess\State\StateInterface;
use Override;

/**
 * Абстрактный класс сущности, с базовой реализацией методов.
 *
 * @package Demai\BusinessProcess\Entity
 * @author Artem Isamiddinov <artemisamiddinov@gmail.com>
 * @version 1.0.0
 */
abstract class BaseEntity implements EntityInterface
{
    /**
     * @var StateInterface Текущее состояние сущности.
     */
    protected StateInterface $state;


    /**
     * {@inheritDoc}
     */
    #[Override]
    public function getState(): StateInterface
    {
        return $this->state;
    }

    /**
     * {@inheritDoc}
     *
     * В реализации состояние записывается напрямую без дополнительной логики.
     */
    #[Override]
    public function setState(StateInterface $state, mixed $context = null): bool|string
    {
        $this->state = $state;
        return true;
    }
}
