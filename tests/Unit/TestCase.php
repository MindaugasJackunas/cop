<?php

declare(strict_types = 1);

namespace App\Tests\Unit;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class TestCase
 */
class TestCase extends PhpUnitTestCase
{
    /**
     * Return mock with specific invocations.
     *
     * @param string $className
     * @param array $invocations
     *
     * @return MockObject|PHPUnit_Framework_MockObject_MockObject
     */
    protected function getMockWithInvocations(string $className, array $invocations)
    {
        $mock = $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();

        foreach ($invocations as $method => $invocation) {
            list($expectation, $with, $will) = $invocation;

            if (isset($expectation)) {
                $expectationInvocation = $mock->expects($expectation)
                    ->method($method);

                if (isset($with)) {
                    $withInvocation = $expectationInvocation->with(...$with);

                    if (isset($will)) {
                        $withInvocation->will($will);
                    }
                }
            }
        }

        return $mock;
    }
}
