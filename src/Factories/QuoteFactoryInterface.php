<?php

declare(strict_types = 1);

namespace App\Factories;

use App\ValueObjects\Quotation;

/**
 * Class QuoteFactoryInterface
 */
interface QuoteFactoryInterface
{
    /**
     * @param string $pair
     * @param float $rate
     *
     * @return Quotation
     */
    public function make(string $pair, float $rate) : Quotation;
}
