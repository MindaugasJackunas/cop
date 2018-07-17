<?php

declare(strict_types = 1);

namespace App\Factories;

use App\Enumerations\OperationType;
use App\ValueObjects\CurrencySumInterface;
use App\ValueObjects\Customer;
use App\ValueObjects\OperationInterface;
use DateTime;

/**
 * Interface OperationFactoryInterface
 */
interface OperationFactoryInterface
{
    /**
     * @param array $csvData
     *
     * @return OperationInterface
     */
    public function makeFromCsvArray(array $csvData) : OperationInterface;

    /**
     * @param DateTime $date
     * @param Customer $customer
     * @param OperationType $operationType
     * @param CurrencySumInterface $currencySum
     *
     * @return OperationInterface
     */
    public function make(
        DateTime $date,
        Customer $customer,
        OperationType $operationType,
        CurrencySumInterface $currencySum
    ) : OperationInterface;
}
