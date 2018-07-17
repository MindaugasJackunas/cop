<?php

declare(strict_types = 1);

namespace App\ValueObjects;

use App\Enumerations\Currency;

/**
 * Interface CurrencySumInterface
 */
interface CurrencySumInterface
{
    /**
     * @return float
     */
    public function getSum() : float;

    /**
     * @return Currency
     */
    public function getCurrency() : Currency;
}
