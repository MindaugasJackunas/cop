<?php

declare(strict_types = 1);

namespace App\Processor;

use App\CommissionCalculator\CommissionCalculatorInterface;
use App\Formatters\CommissionFormatterInterface;
use App\OperationProvider\OperationProviderInterface;
use App\ValueObjects\OperationInterface;

/**
 * Class Processor
 */
class Processor implements ProcessorInterface
{
    /**
     * @var OperationProviderInterface
     */
    private $operationProvider;

    /**
     * @var CommissionCalculatorInterface
     */
    private $commissionCalculator;

    /**
     * @var CommissionFormatterInterface
     */
    private $commissionFormatter;

    /**
     * Processor constructor.
     *
     * @param OperationProviderInterface $operationProvider
     * @param CommissionCalculatorInterface $commissionCalculator
     * @param CommissionFormatterInterface $commissionFormatter
     */
    public function __construct(
        OperationProviderInterface $operationProvider,
        CommissionCalculatorInterface $commissionCalculator,
        CommissionFormatterInterface $commissionFormatter
    ) {
        $this->operationProvider = $operationProvider;
        $this->commissionCalculator = $commissionCalculator;
        $this->commissionFormatter = $commissionFormatter;
    }

    /**
     * {@inheritdoc}
     */
    public function process(string $fileName) : iterable
    {
        /** @var OperationInterface $operation */
        foreach ($this->operationProvider->getOperations($fileName) as $operation) {
            yield $this->commissionFormatter->format(
                $this->commissionCalculator->calculate($operation),
                $operation->getCurrencySum()->getCurrency()->getRoundingPrecision()
            );
        }
    }
}
