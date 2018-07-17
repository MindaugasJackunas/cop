<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules;

use App\Enumerations\CustomerType;
use App\Enumerations\OperationType;
use App\ValueObjects\OperationInterface;

/**
 * Class MaxCommissionRule
 */
class MaxCommissionRule extends PercentageRule implements RuleInterface
{
    /**
     * @var float
     */
    private $maximalCommission;

    /**
     * MaxCommissionRule constructor.
     *
     * @param OperationType $operationType
     * @param CustomerType $customerType
     * @param float $percentage
     * @param float $maximalCommission
     */
    public function __construct(
        OperationType $operationType,
        CustomerType $customerType,
        float $percentage,
        float $maximalCommission
    ) {
        parent::__construct($operationType, $customerType, $percentage);

        $this->maximalCommission = $maximalCommission;
    }

    /**
     * {@inheritdoc}
     */
    public function getCommission(OperationInterface $operation) : float
    {
        $commissionByPercentage = parent::getCommission($operation);

        return $commissionByPercentage < $this->getMaximalCommission()
            ? $commissionByPercentage
            : $this->getMaximalCommission();
    }

    /**
     * @return float
     */
    public function getMaximalCommission() : float
    {
        return $this->maximalCommission;
    }
}
