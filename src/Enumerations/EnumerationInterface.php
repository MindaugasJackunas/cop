<?php

declare(strict_types = 1);

namespace App\Enumerations;

/**
 * Interface EnumerationInterface
 */
interface EnumerationInterface
{
    /**
     * Returns string representation of the enumeation.
     *
     * @return string
     */
    public function __toString() : string;

    /**
     * Returns valid enumeration values.
     *
     * @return array
     */
    public static function getValidValues() : array;
}
