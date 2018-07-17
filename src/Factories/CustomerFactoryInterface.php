<?php

declare(strict_types = 1);

namespace App\Factories;

use App\Enumerations\CustomerType;
use App\ValueObjects\Customer;

/**
 * Interface CustomerFactoryInterface
 */
interface CustomerFactoryInterface
{
    /**
     * @param int $customerId
     * @param CustomerType $customerType
     *
     * @return Customer
     */
    public function make(int $customerId, CustomerType $customerType) : Customer;
}
