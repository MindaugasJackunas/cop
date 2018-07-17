<?php

declare(strict_types = 1);

namespace App\Enumerations;

/**
 * Interface CurrencyInterface
 */
interface CurrencyInterface
{
    /**
     * @return int
     */
    public function getRoundingPrecision() : int;
}
