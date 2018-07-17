<?php

declare(strict_types = 1);

namespace App\Tests\Unit\Processor;

use App\CommissionCalculator\CommissionCalculator;
use App\Enumerations\Currency;
use App\Enumerations\CustomerType;
use App\Enumerations\OperationType;
use App\Formatters\CommissionFormatter;
use App\OperationProvider\OperationProvider;
use App\Processor\Processor;
use App\Tests\Unit\TestCase;
use App\ValueObjects\CurrencySum;
use App\ValueObjects\Customer;
use App\ValueObjects\Operation;
use DateTime;

/**
 * Class ProcessorTest
 */
class ProcessorTest extends TestCase
{
    /**
     * Data provider for testProcessor.
     */
    public function getProcessorTestData()
    {
        $fileName = 'test98765.csv';
        $commission = 0.123;

        yield [
            $fileName,
            [
                'getOperations' => [
                    $this->once(),
                    [$fileName],
                    $this->returnValue([$this->getOperationMock()])
                ]
            ],
            [
                'calculate' => [
                    $this->once(),
                    [$this->getOperationMock()],
                    $this->returnValue($commission)
                ]
            ],
            [
                'format' => [
                    $this->once(),
                    [$commission],
                    $this->returnValue('formattedCommission')
                ]
            ],
            ['formattedCommission']
        ];
    }

    /**
     * @param string $fileName
     * @param array $operationProviderInvocations
     * @param array $commissionCalculatorInvocations
     * @param array $commissionFormatterInvocations
     * @param iterable $expectedResults
     *
     * @dataProvider getProcessorTestData
     */
    public function testProcessor(
        string $fileName,
        array $operationProviderInvocations,
        array $commissionCalculatorInvocations,
        array $commissionFormatterInvocations,
        iterable $expectedResults
    ) {
        $processor = new Processor(
            $this->getOperationProviderMock($operationProviderInvocations),
            $this->getCommissionCalculatorMock($commissionCalculatorInvocations),
            $this->getCommissionFormatterMock($commissionFormatterInvocations)
        );

        $this->assertEquals($expectedResults, iterator_to_array($processor->process($fileName)));
    }

    /**
     * @return Operation
     */
    private function getOperationMock() : Operation
    {
        return new Operation(
            new DateTime('2010-01-01'),
            new Customer(1, new CustomerType(CustomerType::NATURAL)),
            new OperationType(OperationType::CASH_OUT),
            new CurrencySum(100, new Currency('EUR'))
        );
    }

    /**
     * @param array $operationProviderInvocations
     *
     * @return OperationProvider
     */
    private function getOperationProviderMock(array $operationProviderInvocations) : OperationProvider
    {
        /** @var OperationProvider $operationProviderMock */
        $operationProviderMock = $this->getMockWithInvocations(
            OperationProvider::class,
            $operationProviderInvocations
        );

        return $operationProviderMock;
    }

    /**
     * @param array $commissionCalculatorInvocations
     *
     * @return CommissionCalculator
     */
    private function getCommissionCalculatorMock(array $commissionCalculatorInvocations) : CommissionCalculator
    {
        /** @var CommissionCalculator $commissionCalculatorMock */
        $commissionCalculatorMock = $this->getMockWithInvocations(
            CommissionCalculator::class,
            $commissionCalculatorInvocations
        );

        return $commissionCalculatorMock;
    }

    /**
     * @param array $commissionFormatterInvocations
     *
     * @return CommissionFormatter
     */
    private function getCommissionFormatterMock(array $commissionFormatterInvocations) : CommissionFormatter
    {
        /** @var CommissionFormatter $commissionFormatterMock */
        $commissionFormatterMock = $this->getMockWithInvocations(
            CommissionFormatter::class,
            $commissionFormatterInvocations
        );

        return $commissionFormatterMock;
    }
}
