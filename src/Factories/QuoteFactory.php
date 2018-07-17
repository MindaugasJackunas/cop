<?php

declare(strict_types = 1);

namespace App\Factories;

use App\Enumerations\Currency;
use App\ValueObjects\Quotation;
use InvalidArgumentException;

/**
 * Class QuoteFactory
 */
class QuoteFactory implements QuoteFactoryInterface
{
    const PAIR_SEPARATOR = '/\//';

    /**
     * @param string $pair
     * @param float $rate
     *
     * @return Quotation
     */
    public function make(string $pair, float $rate) : Quotation
    {
        $pairs = preg_split(self::PAIR_SEPARATOR, $pair);

        if ($pairs === false || count($pairs) !== 2) {
            throw new InvalidArgumentException("Invalid quote pair '{$pair}'");
        }

        list($fixedCurrencyString, $variableCurrencyString) = $pairs;

        return new Quotation(
            new Currency($fixedCurrencyString),
            new Currency($variableCurrencyString),
            $rate
        );
    }
}
