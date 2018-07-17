<?php

declare(strict_types = 1);

namespace App\ValueObjects;

use App\Enumerations\Currency;

/**
 * Class Quotation
 */
class Quotation implements QuotationInterface
{
    /**
     * @var Currency
     */
    private $fixedCurrency;

    /**
     * @var Currency
     */
    private $variableCurrency;

    /**
     * @var float
     */
    private $rate;

    /**
     * Quatation constructor.
     *
     * @param Currency $fixedCurrency
     * @param Currency $variableCurrency
     * @param float $rate
     */
    public function __construct(Currency $fixedCurrency, Currency $variableCurrency, float $rate)
    {
        $this->fixedCurrency = $fixedCurrency;
        $this->variableCurrency = $variableCurrency;
        $this->rate = $rate;
    }

    /**
     * {@inheritdoc}
     */
    public function getFixedCurrency() : Currency
    {
        return $this->fixedCurrency;
    }

    /**
     * {@inheritdoc}
     */
    public function getVariableCurrency() : Currency
    {
        return $this->variableCurrency;
    }

    /**
     * {@inheritdoc}
     */
    public function getRate() : float
    {
        return $this->rate;
    }
}
