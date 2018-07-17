<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules;

use App\CommissionCalculator\Rules\FreeCommissionRuleAspects\WeeklyTotals;
use App\Enumerations\CustomerType;
use App\Enumerations\OperationType;
use App\Factories\OperationFactoryInterface;
use App\Normalizer\NormalizerInterface;
use App\ValueObjects\CurrencySum;
use App\ValueObjects\OperationInterface;
use Exception;

/**
 * Class FreeCommissionRule
 */
class FreeCommissionRule extends PercentageRule implements RuleInterface
{
    /**
     * @var float
     */
    private $freeSum;

    /**
     * @var int
     */
    private $freeCount;

    /**
     * @var WeeklyTotals[]
     */
    private $weeklyTotals = [];

    /**
     * @var NormalizerInterface
     */
    private $normalizer;

    /**
     * @var OperationFactoryInterface
     */
    private $operationFactory;

    /**
     * FreeCommissionRule constructor.
     *
     * @param OperationType $operationType
     * @param CustomerType $customerType
     * @param float $percentage
     * @param float $freeSum
     * @param int $freeCount
     * @param NormalizerInterface $normalizer
     * @param OperationFactoryInterface $operationFactory
     */
    public function __construct(
        OperationType $operationType,
        CustomerType $customerType,
        float $percentage,
        float $freeSum,
        int $freeCount,
        NormalizerInterface $normalizer,
        OperationFactoryInterface $operationFactory
    ) {
        parent::__construct($operationType, $customerType, $percentage);

        $this->freeSum = $freeSum;
        $this->freeCount = $freeCount;

        $this->normalizer = $normalizer;
        $this->operationFactory = $operationFactory;
    }

    /**
     * @return float
     */
    public function getFreeSum() : float
    {
        return $this->freeSum;
    }

    /**
     * @return int
     */
    public function getFreeCount() : int
    {
        return $this->freeCount;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function getCommission(OperationInterface $operation): float
    {
        $this->preUpdate($operation);

        $operationForCommission = $this->operationFactory->make(
            $operation->getDate(),
            $operation->getCustomer(),
            $operation->getOperationType(),
            $this->getSumForCommission($operation)
        );

        $commission = parent::getCommission($operationForCommission);

        $this->update($operation);

        return $commission;
    }

    /**
     * @param OperationInterface $operation
     *
     * @return CurrencySum
     *
     * @throws Exception
     */
    private function getSumForCommission(OperationInterface $operation)
    {
        $sumForCommission = $operation->getCurrencySum()->getSum();

        $sumForCommission = $this->hasAvailableFreeSum($operation)
            ? max(0, $sumForCommission - $this->getAvailableFreeSum($operation))
            : $sumForCommission;

        return new CurrencySum($sumForCommission, $operation->getCurrencySum()->getCurrency());
    }

    /**
     * @param OperationInterface $operation
     */
    private function preUpdate(OperationInterface $operation)
    {
        if (!isset($this->weeklyTotals[$operation->getWeekId()])) {
            $this->init($operation);
        }

        $this->getWeekTotals($operation)->preUpdate($operation);
    }

    /**
     * @param OperationInterface $operation
     */
    private function update(OperationInterface $operation)
    {
        $this->preUpdate($operation);

        $this->getWeekTotals($operation)->update($this->normalizer->normalize($operation));
    }

    /**
     * @param OperationInterface $operation
     */
    private function init(OperationInterface $operation)
    {
        $this->weeklyTotals = [$operation->getWeekId() => new WeeklyTotals()];
    }

    /**
     * @param OperationInterface $operation
     *
     * @return WeeklyTotals
     */
    private function getWeekTotals(OperationInterface $operation) : WeeklyTotals
    {
        return $this->weeklyTotals[$operation->getWeekId()];
    }

    /**
     * @param OperationInterface $operation
     *
     * @return bool
     *
     * @throws Exception
     */
    private function hasAvailableFreeSum(OperationInterface $operation) : bool
    {
        $totals = $this->getWeekTotals($operation)
            ->getCustomerTotals($operation->getCustomer())
            ->getOperationTotals();

        return ($totals->getCountTotals() <= $this->getFreeCount())
            && ($totals->getSumTotals() <= $this->getFreeSum());
    }

    /**
     * @param OperationInterface $operation
     *
     * @return float
     */
    private function getAvailableFreeSum(OperationInterface $operation) : float
    {
        $totals = $totals = $this->getWeekTotals($operation)
            ->getCustomerTotals($operation->getCustomer())
            ->getOperationTotals();

        $availableFreeSum = $this->getFreeSum() - $totals->getSumTotals();

        return $this->normalizer->denormalize($operation, $availableFreeSum);
    }
}
