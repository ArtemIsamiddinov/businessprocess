<?php

declare(strict_types=1);

namespace Demai\BusinessProcess;

use Demai\BusinessProcess\Entity\EntityInterface;
use Demai\BusinessProcess\State\StateInterface;

class StateRouter
{
    public function __construct(protected ?EntityInterface $entity)
    {
    }

    public function setState(StateInterface $state, bool $skipWay = false) : bool|string
    {
        if(!$skipWay){
            $stateWay = $this->entity->getState()->getNext();
            if(count(array_filter($stateWay, fn($ws) : bool => $ws::class === $state::class)) === 0){
                return "incorrect state";
            }
        }

        $validate = $state->getValidator()->validate($this->entity);
        if($validate !== true){
            return $validate;
        }

        return $this->entity->setState($state);
    }
}