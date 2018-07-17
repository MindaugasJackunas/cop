<?php

declare(strict_types = 1);

namespace App\Factories;

use App\Enumerations\Currency;
use App\Enumerations\CustomerType;
use App\Enumerations\OperationType;
use App\ValueObjects\CurrencySumInterface;
use App\ValueObjects\Customer;
use App\ValueObjects\Operation;
use App\ValueObjects\OperationInterface;
use DateTime;
use InvalidArgumentException;

/**
 * Class OperationFactory
 */
class OperationFactory implements OperationFactoryInterface
{
    /**
     * @var CustomerFactoryInterface
     */
    private $customerFactory;

    /**
     * @var CurrencySumFactoryInterface
     */
    private $currencySumFactory;

    /**
     * OperationFactory constructor.
     *
     * @param CustomerFactoryInterface $customerFactory
     * @param CurrencySumFactoryInterface $currencySumFactory
     */
    public function __construct(
        CustomerFactoryInterface $customerFactory,
        CurrencySumFactoryInterface $currencySumFactory
    ) {

        $this->customerFactory = $customerFactory;
        $this->currencySumFactory = $currencySumFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function makeFromCsvArray(array $csvData) : OperationInterface
    {
        if (count($csvData) !== 6) {
            throw new InvalidArgumentException('Bad CSV data column count.');
        }

        return new Operation(
            new DateTime((string) $csvData[0]),
            $this->customerFactory->make((int) $csvData[1], new CustomerType($csvData[2])),
            new OperationType($csvData[3]),
            $this->currencySumFactory->make((float)$csvData[4], new Currency($csvData[5]))
        );
    }

    /**
     * {@inheritdoc}
     */
    public function make(
        DateTime $date,
        Customer $customer,
        OperationType $operationType,
        CurrencySumInterface $currencySum
    ) : OperationInterface {
        return new Operation($date, $customer, $operationType, $currencySum);
    }
}
