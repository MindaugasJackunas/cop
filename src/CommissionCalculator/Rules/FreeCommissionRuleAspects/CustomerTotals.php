<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules\FreeCommissionRuleAspects;

use App\ValueObjects\CurrencySum;

/**
 * Class CustomerTotals
 */
class CustomerTotals
{
    /**
     * @var OperationTotals
     */
    private $operationTotals;

    /**
     * CustomerTotals constructor.
     */
    public function __construct()
    {
        $this->operationTotals = new OperationTotals();
    }

    /**
     * @param CurrencySum $currencySum
     */
    public function update(CurrencySum $currencySum)
    {
        $this->operationTotals->update($currencySum);
    }

    /**
     * @return OperationTotals
     */
    public function getOperationTotals() : OperationTotals
    {
        return $this->operationTotals;
    }
}
