<?php

declare(strict_types = 1);

namespace App\CurrencyExchange;

use App\Enumerations\Currency;
use App\ValueObjects\CurrencySumInterface;

/**
 * Interface CurrencyExchangeInterface
 */
interface CurrencyExchangeInterface
{
    /**
     * @param CurrencySumInterface $currencySum
     * @param Currency $toCurrency
     *
     * @return CurrencySumInterface
     */
    public function exchange(CurrencySumInterface $currencySum, Currency $toCurrency) : CurrencySumInterface;
}
