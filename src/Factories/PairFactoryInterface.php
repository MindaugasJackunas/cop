<?php

declare(strict_types = 1);

namespace App\Factories;

use App\Enumerations\Currency;

/**
 * Interface PairFactoryInterface
 */
interface PairFactoryInterface
{
    /**
     * @param Currency $fixedCurrency
     * @param Currency $variableCurrency
     *
     * @return string
     */
    public function make(Currency $fixedCurrency, Currency $variableCurrency) : string;
}
