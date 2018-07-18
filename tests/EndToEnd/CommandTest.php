<?php

declare(strict_types = 1);

namespace App\Tests\EndToEnd;

use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ProcessCommandTest
 */
class CommandTest extends CommandTestCase
{
    /**
     * Returns test data for testExecute.
     *
     * @return iterable
     */
    public static function getConsoleCommandTestData() : iterable
    {
        $inputFileName = __DIR__ . '/../Resources/input.csv';
        $expectedOutput = file_get_contents(__DIR__ . '/../Resources/commissions.txt');

        // Case #0: Works as expected.
        yield [
            'cop:process',
            ['fileName' => $inputFileName],
            $expectedOutput,
            null
        ];

        // Case #1: file name argument is not provided.
        yield [
            'cop:process',
            [],
            $expectedOutput,
            RuntimeException::class
        ];
    }

    /**
     * Tests command execution.
     *
     * @param string $commandName
     * @param array $arguments
     * @param string $expectedOutput
     * @param string|null $expectedException
     *
     * @dataProvider getConsoleCommandTestData
     */
    public function testExecute(
        string $commandName,
        array $arguments,
        string $expectedOutput,
        string $expectedException = null
    ) {
        $command = $this->application->find($commandName);

        $commandTester = new CommandTester($command);

        if (isset($expectedException)) {
            $this->expectException($expectedException);
        }

        $commandTester->execute($arguments);
        $this->assertEquals($expectedOutput, $commandTester->getDisplay());
    }
}
