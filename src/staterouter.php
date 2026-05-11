<?php

declare(strict_types=1);

namespace Demai\BusinessProcess;

use Demai\BusinessProcess\Entity\EntityInterface;
use Demai\BusinessProcess\State\StateInterface;

class StateRouter
{
    public function __construct(protected ?IntityInterface $entity)
    {
    }

    public function setState(StateInterface $state, bool $skipWay = false) : bool|string
    {
        if(!$skipWay){
            $stateWay = $entity->getState()->getNext();
            if(count(array_filter($stateWay, fn($ws) : bool => $ws::class === $state::class)) === 0){
                return "incorrect state";
            }
        }

        $validate = $state->getValidator()->validate($this->entity);
        if($validate !== true){
            return $validate;
        }
        
        return $state->setState($state);
    }

    //Сделать метод который будет возвращать роутер с новым состоянием сущности
    //Седалть метод который будет отправлять сущность на новую стадию с возможностью пропуска полной карты событий
    //Сделать валидатор перехода по стадиям приписать его к сущности или передавать явно
}