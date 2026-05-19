<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use \Closure;
use Demai\BusinessProcess\Entity\BaseEntity;
use Demai\BusinessProcess\NullStateValidator;
use Demai\BusinessProcess\State\BaseState;
use Demai\BusinessProcess\State\NullState;
use Demai\BusinessProcess\StateRouter;
use Demai\BusinessProcess\StateValidatorInterface;
use Demai\BusinessProcess\Entity\EntityInterface;

final class RouteEntityTest extends TestCase
{
    /**
     * @dataProvider entityProvider
     */
    public function testRouteEntity(\Closure $entityClosure, \Closure $targetStateClosure, bool $skipWay, mixed $expect): void
    {
        $entity = $entityClosure($this);
        $targetState = $targetStateClosure($this);
        $router = new StateRouter($entity);

        $res = $router->setState($targetState, $skipWay);
        $this->assertSame($expect, $res, "Некорректный результат при проверке перехода на статус: {$res}");
    }

    public static function entityProvider(): array
    {
        return [
            'to NullState with NullStateValidator' => [
                'entityClosure' => function(TestCase $case) {
                    $fromStateStub = $case->createConfiguredStub(
                        BaseState::class, 
                        [
                            'getValidator' => new NullStateValidator(),
                            'getNext' => [new NullState()]
                        ]
                    );

                    $entity = $case->getMockBuilder(BaseEntity::class)->disableOriginalConstructor()->onlyMethods(['getState'])->getMock();
                    $entity->method('getState')->willReturn($fromStateStub);

                    return $entity;
                },
                'targetStateClosure' => function(TestCase $case) {
                    return new NullState();
                },
                'skipWay' => false,
                'expect' => true
            ],
            'to incorrect state' => [
                'entityClosure' => function(TestCase $case) {
                    $entity = $case->getMockBuilder(BaseEntity::class)->disableOriginalConstructor()->onlyMethods(['getState'])->getMock();
                    $entity->method('getState')->willReturn(new NullState());

                    return $entity;
                },
                'targetStateClosure' => function(TestCase $case) {
                    return new NullState();
                },
                'skipWay' => false,
                'expect' => 'incorrect state'
            ],
            'to state with validator error' => [
                'entityClosure' => function(TestCase $case) {
                    $entityMock = $case->getMockBuilder(BaseEntity::class)->disableOriginalConstructor()->onlyMethods(['getState'])->getMock();
                    $entityMock->method('getState')->willReturn(new NullState());

                    return $entityMock;
                },
                'targetStateClosure' => function(TestCase $case) {
                    $validatorStub = $case->createConfiguredStub(StateValidatorInterface::class, [
                        'validate' => 'validator called error'
                    ]);
                    return $case->createConfiguredStub(BaseState::class, [
                        'getNext' => [],
                        'getValidator' => $validatorStub
                    ]);
                },
                'skipWay' => true,
                'expect' => 'validator called error'
            ]
        ];
    }
}