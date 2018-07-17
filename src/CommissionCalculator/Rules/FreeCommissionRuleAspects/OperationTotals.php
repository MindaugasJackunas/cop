<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules\FreeCommissionRuleAspects;

use App\ValueObjects\CurrencySum;

/**
 * Class OperationTotals
 */
class OperationTotals
{
    /**
     * @var float
     */
    private $sumTotals = 0;

    /**
     * @var int
     */
    private $countTotals = 0;

    /**
     * @return float
     */
    public function getSumTotals() : float
    {
        return $this->sumTotals;
    }

    /**
     * @return int
     */
    public function getCountTotals() : int
    {
        return $this->countTotals;
    }

    /**
     * @param CurrencySum $currencySum
     */
    public function update(CurrencySum $currencySum)
    {
        $this->sumTotals += $currencySum->getSum();
        $this->countTotals++;
    }
}
