<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules;

use App\ValueObjects\OperationInterface;

/**
 * Interface RuleProviderInterface
 */
interface RuleProviderInterface
{
    /**
     * @param OperationInterface $operation
     *
     * @return RuleInterface
     */
    public function getRule(OperationInterface $operation) : RuleInterface;

    /**
     * @param OperationInterface $operation
     *
     * @return bool
     */
    public function ruleExists(OperationInterface $operation) : bool;

    /**
     * @return mixed
     */
    public function setupRules();
}
