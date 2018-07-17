<?php

declare(strict_types = 1);

namespace App\ValueObjects;

use App\Enumerations\OperationType;
use DateTime;

/**
 * Class Operation
 */
class Operation implements OperationInterface
{
    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $weekId;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var OperationType
     */
    private $operationType;

    /**
     * @var CurrencySumInterface
     */
    private $currencySum;

    /**
     * Operation constructor.
     *
     * @param DateTime $date
     * @param Customer $customer
     * @param OperationType $operationType
     * @param CurrencySumInterface $currencySum
     */
    public function __construct(
        DateTime $date,
        Customer $customer,
        OperationType $operationType,
        CurrencySumInterface $currencySum
    ) {
        $this->date = $date;
        $this->weekId = $date->format('oW');
        $this->customer = $customer;
        $this->operationType = $operationType;
        $this->currencySum = $currencySum;
    }

    /**
     * @return DateTime
     */
    public function getDate() : DateTime
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getWeekId() : string
    {
        return $this->weekId;
    }

    /**
     * @return Customer
     */
    public function getCustomer() : Customer
    {
        return $this->customer;
    }

    /**
     * @return OperationType
     */
    public function getOperationType() : OperationType
    {
        return $this->operationType;
    }

    /**
     * @return CurrencySumInterface
     */
    public function getCurrencySum() : CurrencySumInterface
    {
        return $this->currencySum;
    }
}
