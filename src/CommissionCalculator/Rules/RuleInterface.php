<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules;

use App\ValueObjects\OperationInterface;

/**
 * Class RuleInterface
 */
interface RuleInterface
{
    /**
     * @param OperationInterface $operation
     *
     * @return float
     */
    public function getCommission(OperationInterface $operation) : float;
}
