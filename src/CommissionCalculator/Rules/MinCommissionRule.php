<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules;

use App\Enumerations\CustomerType;
use App\Enumerations\OperationType;
use App\ValueObjects\OperationInterface;

/**
 * Class MinCommissionRule
 */
class MinCommissionRule extends PercentageRule implements RuleInterface
{
    /**
     * @var float
     */
    private $minimalCommission;

    /**
     * MinCommissionRule constructor.
     *
     * @param OperationType $operationType
     * @param CustomerType $customerType
     * @param float $percentage
     * @param float $minimalCommission
     */
    public function __construct(
        OperationType $operationType,
        CustomerType $customerType,
        float $percentage,
        float $minimalCommission
    ) {
        parent::__construct($operationType, $customerType, $percentage);

        $this->minimalCommission = $minimalCommission;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommission(OperationInterface $operation) : float
    {
        $commissionByPercentage = parent::getCommission($operation);

        return $commissionByPercentage < $this->getMinimalCommission()
            ? $this->getMinimalCommission()
            : $commissionByPercentage;
    }

    /**
     * @return float
     */
    public function getMinimalCommission() : float
    {
        return $this->minimalCommission;
    }
}
