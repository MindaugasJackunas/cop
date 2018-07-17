<?php

declare(strict_types = 1);

namespace App\CommissionCalculator;

use App\CommissionCalculator\Rules\RuleProviderInterface;
use App\Formatters\CommissionFormatterInterface;
use App\ValueObjects\OperationInterface;
use Exception;

/**
 * Class CommissionCalculator
 */
class CommissionCalculator implements CommissionCalculatorInterface
{
    /**
     * @var RuleProviderInterface
     */
    private $ruleProvider;

    /**
     * @var CommissionFormatterInterface
     */
    private $commissionFormatter;

    /**
     * CommissionCalculator constructor.
     *
     * @param RuleProviderInterface $ruleProvider
     * @param CommissionFormatterInterface $commissionFormatter
     */
    public function __construct(
        RuleProviderInterface $ruleProvider,
        CommissionFormatterInterface $commissionFormatter
    ) {
        $this->ruleProvider = $ruleProvider;
        $this->commissionFormatter = $commissionFormatter;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function calculate(OperationInterface $operation) : float
    {
        $rule = $this->ruleProvider->getRule($operation);
        $finalCommission = $rule->getCommission($operation);

        return $this->commissionFormatter->roundUp(
            $finalCommission,
            $operation->getCurrencySum()->getCurrency()->getRoundingPrecision()
        );
    }
}
