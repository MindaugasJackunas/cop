<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules;

use App\Enumerations\CustomerType;
use App\Enumerations\OperationType;

/**
 * Class PhpRuleProvider
 */
class PhpRuleProvider extends BaseRuleProvider implements RuleProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function setupRules()
    {
        $this->rules =[
            OperationType::CASH_IN => [
                CustomerType::LEGAL => new MaxCommissionRule(
                    new OperationType(OperationType::CASH_IN),
                    new CustomerType(CustomerType::LEGAL),
                    0.03,
                    5.0
                ),
                CustomerType::NATURAL => new MaxCommissionRule(
                    new OperationType(OperationType::CASH_IN),
                    new CustomerType(CustomerType::NATURAL),
                    0.03,
                    5.0
                )
            ],
            OperationType::CASH_OUT => [
                CustomerType::LEGAL => new MinCommissionRule(
                    new OperationType(OperationType::CASH_OUT),
                    new CustomerType(CustomerType::LEGAL),
                    0.3,
                    0.5
                ),
                CustomerType::NATURAL => new FreeCommissionRule(
                    new OperationType(OperationType::CASH_OUT),
                    new CustomerType(CustomerType::NATURAL),
                    0.3,
                    1000,
                    3,
                    $this->normalizer,
                    $this->operationFactory
                )
            ]
        ];
    }
}
