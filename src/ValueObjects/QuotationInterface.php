<?php

declare(strict_types = 1);

namespace App\ValueObjects;

use App\Enumerations\Currency;

/**
 * Interface QuotationInterface
 */
interface QuotationInterface
{
    /**
     * @return Currency
     */
    public function getFixedCurrency() : Currency;

    /**
     * @return Currency
     */
    public function getVariableCurrency() : Currency;

    /**
     * @return float
     */
    public function getRate() : float;
}
