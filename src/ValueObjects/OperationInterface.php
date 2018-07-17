<?php

declare(strict_types = 1);

namespace App\ValueObjects;

use App\Enumerations\OperationType;
use DateTime;

/**
 * Class OperationInterface
 */
interface OperationInterface
{
    /**
     * @return DateTime
     */
    public function getDate() : DateTime;

    /**
     * @return string
     */
    public function getWeekId() : string;

    /**
     * @return Customer
     */
    public function getCustomer() : Customer;

    /**
     * @return OperationType
     */
    public function getOperationType() : OperationType;

    /**
     * @return CurrencySum
     */
    public function getCurrencySum() : CurrencySumInterface;
}
