<?php

declare(strict_types = 1);

namespace App\Factories;

use App\Enumerations\CustomerType;
use App\ValueObjects\Customer;

/**
 * Class CustomerFactory
 */
class CustomerFactory implements CustomerFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function make(int $customerId, CustomerType $customerType) : Customer
    {
        return new Customer(
            $customerId,
            $customerType
        );
    }
}
