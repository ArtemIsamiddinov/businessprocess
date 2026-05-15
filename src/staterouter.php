<?php

declare(strict_types=1);

namespace Demai\BusinessProcess;

use Demai\BusinessProcess\Entity\EntityInterface;
use Demai\BusinessProcess\State\StateInterface;
use Demai\BusinessProcess\StateChangedEvent;
use Psr\EventDispatcher\EventDispatcherInterface;

class StateRouter
{
    public function __construct(
        protected ?EntityInterface $entity, 
        protected ?EventDispatcherInterface $dispatcher = null
    ) {}

    public function setState(StateInterface $state, bool $skipWay = false, mixed $context = null): bool|string
    {
        if (!$skipWay) {
            $stateWay = $this->entity->getState()->getNext();
            if (count(array_filter($stateWay, fn($ws): bool => $ws::class === $state::class)) === 0) {
                return "incorrect state";
            }
        }

        $validate = $state->getValidator()->validate($this->entity);
        if ($validate !== true) {
            return $validate;
        }

        $fromState = $this->entity->getState();
        $result = $this->entity->setState($state);
        if($result === true && $this->dispatcher !== null) {
            $this->dispatcher->dispatch(
                new StateChangedEvent($this->entity, $fromState, $state, $context)
            );
        }

        return $this->entity->setState($state);
    }
}
