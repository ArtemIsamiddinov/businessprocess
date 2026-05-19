<?php

declare(strict_types=1);

namespace Demai\BusinessProcess\Tests;

use Demai\BusinessProcess\State\BaseState;
use PHPUnit\Framework\TestCase;
use Demai\BusinessProcess\State\NullState;
use Demai\BusinessProcess\State\StateInterface;

final class StateTest extends TestCase
{

    /**
     * @dataProvider stateProvider
     */
    public function testGetNext(\Closure $stateClosure, array $expect): void
    {
        $state = $stateClosure($this);
        $this->assertEquals($expect, $state->getNext(), "При получении статусов методом getNext результат оказался неверным");
    }

    public static function stateProvider(): array
    {
        return [
            'NullState case' => [
                'stateClosure' => function(TestCase $case): StateInterface
                {
                    return new NullState();
                },
                'expect' => []
            ],
            'MockState with NullState case' => [
                'stateClosure' => function(TestCase $case): StateInterface
                {
                    $mock = $case->getMockBuilder(BaseState::class)
                        ->disableOriginalConstructor()
                        ->onlyMethods(['getNext'])
                        ->getMock();
                    $mock->method('getNext')->willReturn([new NullState()]);
                    /**
                     * @var StateInterface $mock
                     */
                    return $mock;
                },
                'expect' => [new NullState()]
            ]
        ];
    }
}