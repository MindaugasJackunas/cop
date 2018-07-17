<?php

declare(strict_types = 1);

namespace App\Factories;

use App\Enumerations\Currency;
use App\ValueObjects\CurrencySum;

/**
 * Class CurrencySumFactory
 */
class CurrencySumFactory implements CurrencySumFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function make(float $sum, Currency $currency): CurrencySum
    {
        return new CurrencySum(
            $sum,
            $currency
        );
    }
}
