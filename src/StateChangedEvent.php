<?php

declare(strict_types=1);

namespace Demai\BusinessProcess;

use Demai\BusinessProcess\Entity\EntityInterface;
use Demai\BusinessProcess\State\StateInterface;

/**
 * Класс события, которое посылается при переходе сущности в новое состояние.
 *
 * @package Demai\BusinessProcess
 * @author Artem Isamiddinov <artemisamiddinov@gmail.com>
 * @version 1.0.0
 */
class StateChangedEvent
{
    /**
     * @param EntityInterface $entity Сущность, которая перешла в новое состояние.
     * @param StateInterface $fromState Состояние, с которого был выполнен переход.
     * @param StateInterface $toState Состояние, в которое был выполнен переход.
     * @param mixed $context Контекст события. Дополнительные данные, которые необходимо указать в событии.
     */
    public function __construct(
        public readonly EntityInterface $entity,
        public readonly StateInterface $fromState,
        public readonly StateInterface $toState,
        public readonly mixed $context = null
    ) {
    }
}
