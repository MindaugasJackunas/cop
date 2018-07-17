<?php

declare(strict_types = 1);

namespace App\ValueObjects;

use App\Enumerations\Currency;

/**
 * Class Currency
 */
class CurrencySum implements CurrencySumInterface
{
    /**
     * @var float
     */
    private $sum;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * CurrencySum constructor.
     *
     * @param float $sum
     * @param Currency $currency
     */
    public function __construct(float $sum, Currency $currency)
    {
        $this->sum = $sum;
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getSum() : float
    {
        return $this->sum;
    }

    /**
     * @return Currency
     */
    public function getCurrency() : Currency
    {
        return $this->currency;
    }
}
