<?php

declare(strict_types=1);

namespace Demai\BusinessProcess;

use Demai\BusinessProcess\Entity\EntityInterface;
use Demai\BusinessProcess\State\StateInterface;
use Demai\BusinessProcess\StateChangedEvent;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * Класс роутера, который используется для маршрутизации сущности по состояниям.
 * Цель роутера:
 *  - Проверить корректность пути, по которому следует сущность;
 *  - Запустить проверку при помощи валидатора на возможность перехода на следующий статус;
 *  - Запустить установку статуса для сущности.
 *
 * @package Demai\BusinessProcess
 * @author Artem Isamiddinov <artemisamiddinov@gmail.com>
 * @version 1.0.0
 */
class StateRouter
{
    /**
     * @param EntityInterface $entity Сущность, для которой должна быть выполнена маршрутизация.
     * @param null|EventDispatcherInterface $dispatcher     Диспетчер событий, который должен отправлять события
     *                                                      обработчикам событий.
     */
    public function __construct(
        protected EntityInterface $entity,
        protected ?EventDispatcherInterface $dispatcher = null
    ) {
    }

    /**
     * Установить новое состояние для сущности.
     * Если установлен EventDispatcherInterface, то при успешной смене статуса
     * будет отправлено событие StateChangedEvent.
     *
     * @param StateInterface $state     Состояние сущности, в которое должна перейти сущность.
     * @param bool $skipWay             Флаг пропуска проверки правильности маршрута. В случае если true,
     *                                  проверка правильности маршрута выполнена не будет.
     * @param mixed $context            Контекст перехода сущности в новое состояние. Дополнительные данные,
     *                                  которые необходимо использовать при переходе в новое состояние.
     * @return bool|string              В случае успеха - true, в случае, если что-то пошло не так будет
     *                                  возвращен текст ошибки.
     */
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
        $result = $this->entity->setState($state, $context);
        if ($result === true && $this->dispatcher !== null) {
            $this->dispatcher->dispatch(
                new StateChangedEvent($this->entity, $fromState, $state, $context)
            );
        }

        return $result;
    }
}
