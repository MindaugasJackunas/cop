<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules;

use App\Enumerations\CustomerType;
use App\Enumerations\OperationType;
use App\ValueObjects\OperationInterface;

/**
 * Class AbstractRule
 */
abstract class BaseRule implements RuleInterface
{
    /**
     * @var OperationType
     */
    private $operationType;

    /**
     * @var CustomerType
     */
    private $customerType;

    /**
     * BaseRule constructor.
     *
     * @param OperationType $operationType
     * @param CustomerType $customerType
     */
    public function __construct(
        OperationType $operationType,
        CustomerType $customerType
    ) {
        $this->operationType = $operationType;
        $this->customerType = $customerType;
    }

    /**
     * @return OperationType
     */
    public function getOperationType() : OperationType
    {
        return $this->operationType;
    }

    /**
     * @return CustomerType
     */
    public function getCustomerType() : CustomerType
    {
        return $this->customerType;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getCommission(OperationInterface $operation) : float;
}
