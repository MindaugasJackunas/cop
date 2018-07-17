<?php

declare(strict_types = 1);

namespace App\Factories;

use App\Enumerations\Currency;

/**
 * Class PairFactory
 */
class PairFactory implements PairFactoryInterface
{
    const SEPARATOR = '/';

    /**
     * {@inheritdoc}
     */
    public function make(Currency $fixedCurrency, Currency $variableCurrency) : string
    {
        return (string) $fixedCurrency . self::SEPARATOR . (string) $variableCurrency;
    }
}
