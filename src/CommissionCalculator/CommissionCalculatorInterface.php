<?php

declare(strict_types = 1);

namespace App\CommissionCalculator;

use App\ValueObjects\OperationInterface;

/**
 * Interface CommissionCalculatorInterface
 */
interface CommissionCalculatorInterface
{
    /**
     * @param OperationInterface $operation
     *
     * @return float
     */
    public function calculate(OperationInterface $operation) : float;
}
