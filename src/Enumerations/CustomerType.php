<?php

declare(strict_types = 1);

namespace App\Enumerations;

use InvalidArgumentException;

/**
 * Class CustomerType
 */
class CustomerType implements EnumerationInterface
{
    const NATURAL = 'natural';

    const LEGAL = 'legal';

    /**
     * @var string
     */
    private $customerType;

    /**
     * CustomerType constructor.
     *
     * @param string $customerType
     */
    public function __construct(string $customerType)
    {
        if (self::validate($customerType)) {
            $this->customerType = $customerType;
        } else {
            throw new InvalidArgumentException("Provided customer type '{$customerType}' is not valid.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __toString() : string
    {
        return $this->customerType;
    }

    /**
     * {@inheritdoc}
     */
    public static function getValidValues(): array
    {
        return [
            self::NATURAL,
            self::LEGAL
        ];
    }

    /**
     * @param string $operationType
     *
     * @return bool
     */
    private static function validate(string $customerType) : bool
    {
        return in_array(strtolower($customerType), self::getValidValues());
    }
}
