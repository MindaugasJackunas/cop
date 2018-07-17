<?php

declare(strict_types = 1);

namespace App\Formatters;

use App\Formatters\CommissionFormatterInterface;

/**
 * Class CommissionFormatter
 */
class CommissionFormatter implements CommissionFormatterInterface
{
    const DECIMAL_PLACES = 0;

    const DECIMAL_SEPARATOR = '.';

    const THOUSAND_SEPARATOR = '';

    /**
     * {@inheritdoc}
     */
    public function format(float $commission, int $decimalPlaces = 0) : string
    {
        return number_format(
            $this->roundUp($commission, $decimalPlaces),
            $decimalPlaces,
            self::DECIMAL_SEPARATOR,
            self::THOUSAND_SEPARATOR
        );
    }

    /**
     * {@inheritdoc}
     */
    public function roundUp(float $value, int $decimalPlaces = 0) : float
    {
        if ($decimalPlaces < 0) {
            $decimalPlaces = 0;
        }

        $multi = pow(10, $decimalPlaces);

        return ceil($value * $multi) / $multi;
    }
}
