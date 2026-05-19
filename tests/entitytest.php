<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\Tests;

use Demai\BusinessProcess\Entity\BaseEntity;
use PHPUnit\Framework\TestCase;
use Demai\BusinessProcess\State\NullState;
use Demai\BusinessProcess\State\BaseState;
use Demai\BusinessProcess\State\StateInterface;

class TestState extends BaseState
{
    #[Override]
    public function getNext(): array
    {
        return [];
    }
} 

final class EntityTest extends TestCase
{
    public function testGetState(): void
    {
        $entity = new class extends BaseEntity
        {};
            
        $reflection = new \ReflectionClass($entity);
        $property = $reflection->getProperty('state');
        $property->setValue($entity, new NullState());
    
        $this->assertSame(NullState::class, $entity->getState()::class, "Сущность возвращает некорректный класс состояния");
    }

    /**
     * @dataProvider stateProvider
     */
    public function testSetState(StateInterface $state, string $expected): void
    {
        $entity = new class extends BaseEntity
        {};

        $this->assertTrue($entity->setState($state), "Некорректный ответ при установлении статуса сущности");
        $this->assertSame($entity->getState()::class, $expected, "Возвращаемый статус сущности не соответствует заданному");
    }

    public static function stateProvider(): array
    {
        return [
            'TestState' => [
                'state' => new TestState(),
                'expected' => TestState::class
            ],
            'NullState' => [
                'state' => new NullState(),
                'expected' => NullState::class
            ]
        ];
    }
}