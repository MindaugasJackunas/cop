<?php

declare(strict_types = 1);

namespace App\Enumerations;

use InvalidArgumentException;

/**
 * Class OperationType
 */
class OperationType implements EnumerationInterface
{
    const CASH_IN = 'cash_in';

    const CASH_OUT = 'cash_out';

    /**
     * @var string
     */
    private $operationType;

    /**
     * OperationType constructor.
     *
     * @param string $operationType
     */
    public function __construct(string $operationType)
    {
        if (self::validate($operationType)) {
            $this->operationType = $operationType;
        } else {
            throw new InvalidArgumentException("Provided operation type '{$operationType}' is not valid.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __toString() : string
    {
        return $this->operationType;
    }

    /**
     * {@inheritdoc}
     */
    public static function getValidValues() : array
    {
        return [
            self::CASH_IN,
            self::CASH_OUT
        ];
    }

    /**
     * @param string $operationType
     *
     * @return bool
     */
    private static function validate(string $operationType) : bool
    {
        return in_array(strtolower($operationType), self::getValidValues());
    }
}
