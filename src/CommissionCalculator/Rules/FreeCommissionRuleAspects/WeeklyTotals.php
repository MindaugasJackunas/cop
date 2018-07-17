<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules\FreeCommissionRuleAspects;

use App\ValueObjects\Customer;
use App\ValueObjects\OperationInterface;

/**
 * Class WeeklyTotals
 */
class WeeklyTotals
{
    /**
     * @var CustomerTotals[]
     */
    private $customerTotals = [];

    /**
     * @param OperationInterface $operation
     */
    public function preUpdate(OperationInterface $operation)
    {
        if (!$this->exists($operation->getCustomer())) {
            $this->init($operation->getCustomer());
        }
    }

    /**
     * @param OperationInterface $operation
     */
    public function update(OperationInterface $operation)
    {
        $this->preUpdate($operation);

        $this->customerTotals[$operation->getCustomer()->getId()]->update($operation->getCurrencySum());
    }

    /**
     * @param Customer $customer
     *
     * @return bool
     */
    public function exists(Customer $customer) : bool
    {
        return isset($this->customerTotals[$customer->getId()]);
    }

    /**
     * @param Customer $customer
     *
     * @return CustomerTotals
     */
    public function getCustomerTotals(Customer $customer) : CustomerTotals
    {
        return $this->customerTotals[$customer->getId()];
    }

    /**
     * @param Customer $customer
     */
    private function init(Customer $customer)
    {
        $this->customerTotals[$customer->getId()] = new CustomerTotals();
    }
}
