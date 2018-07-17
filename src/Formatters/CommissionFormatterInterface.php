<?php

declare(strict_types = 1);

namespace App\Formatters;

/**
 * Interface CommissionFormatterInterface
 */
interface CommissionFormatterInterface
{
    /**
     * @param float $commission
     * @param int|0 $decimalPlaces
     *
     * @return string
     */
    public function format(float $commission, int $decimalPlaces = 0) : string;

    /**
     * @param float $value
     * @param int|0 $decimalPlaces
     *
     * @return float
     */
    public function roundUp(float $value, int $decimalPlaces = 0) : float;
}
