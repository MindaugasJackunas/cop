<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules;

use App\Enumerations\CustomerType;
use App\Enumerations\OperationType;
use App\ValueObjects\OperationInterface;

/**
 * Class PercentageRule
 */
class PercentageRule extends BaseRule implements RuleInterface
{
    /**
     * @var float
     */
    private $percentage;

    /**
     * PercentageRule constructor.
     *
     * @param OperationType $operationType
     * @param CustomerType $customerType
     * @param float $percentage
     */
    public function __construct(
        OperationType $operationType,
        CustomerType $customerType,
        float $percentage
    ) {
        parent::__construct($operationType, $customerType);

        $this->percentage = $percentage;
    }

    /**
     * {@inheritdoc
     */
    public function getCommission(OperationInterface $operation) : float
    {
        return $operation->getCurrencySum()->getSum() * $this->getPercentage() / 100;
    }

    /**
     * @return float
     */
    public function getPercentage() : float
    {
        return $this->percentage;
    }
}
