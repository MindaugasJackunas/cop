<?php

declare(strict_types = 1);

namespace App\Factories;

use App\Enumerations\Currency;
use App\ValueObjects\CurrencySum;

/**
 * Interface CurrencySumFactoryInterface
 */
interface CurrencySumFactoryInterface
{
    /**
     * @param float $sum
     * @param Currency $currencyType
     *
     * @return CurrencySum
     */
    public function make(float $sum, Currency $currencyType) : CurrencySum;
}
