<?php

declare(strict_types = 1);

namespace App\Enumerations;

use InvalidArgumentException;

/**
 * Class Currency
 */
class Currency implements EnumerationInterface, CurrencyInterface
{
    /**
     * @var array
     */
    public static $currencies = [
        'EUR' => 2,
        'USD' => 2,
        'JPY' => 0
    ];

    /**
     * @var string
     */
    private $currency;

    /**
     * @var int
     */
    private $roundingPrecision;

    /**
     * Currency constructor.
     *
     * @param string $currency
     */
    public function __construct(string $currency)
    {
        if (self::validate($currency)) {
            $this->currency = $currency;
            $this->roundingPrecision = self::$currencies[$currency];
        } else {
            throw new InvalidArgumentException("Provided currency '{$currency}' is not valid or supported.");
        }
    }

    /**
     * @return int
     */
    public function getRoundingPrecision() : int
    {
        return $this->roundingPrecision;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString() : string
    {
        return $this->currency;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    public static function getValidValues() : array
    {
        return array_keys(self::$currencies);
    }

    /**
     * @return array
     */
    public static function getCurrencies() : array
    {
        return self::$currencies;
    }

    /**
     * @param string $currency
     *
     * @return bool
     *
     * @throws InvalidArgumentException
     */
    private static function validate(string $currency) : bool
    {
        return in_array(strtoupper($currency), self::getValidValues());
    }
}
