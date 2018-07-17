<?php

declare(strict_types = 1);

namespace App\CommissionCalculator\Rules;

use App\Factories\OperationFactoryInterface;
use App\Normalizer\NormalizerInterface;
use App\ValueObjects\OperationInterface;
use Exception;

/**
 * Class BaseRuleProvider
 */
abstract class BaseRuleProvider implements RuleProviderInterface
{
    /**
     * @var array
     */
    protected $rules;

    /**
     * @var NormalizerInterface
     */
    protected $normalizer;

    /**
     * @var OperationFactoryInterface
     */
    protected $operationFactory;

    /**
     * PhpRuleProvider constructor.
     *
     * @param NormalizerInterface $normalizer
     * @param OperationFactoryInterface $operationFactory
     */
    public function __construct(
        NormalizerInterface $normalizer,
        OperationFactoryInterface $operationFactory
    ) {
        $this->normalizer = $normalizer;
        $this->operationFactory = $operationFactory;

        $this->setupRules();
    }

    /**
     * @return mixed
     */
    abstract public function setupRules();

    /**
     * @param OperationInterface $operation
     *
     * @return bool
     */
    public function ruleExists(OperationInterface $operation) : bool
    {
        return isset(
            $this->rules[(string) $operation->getOperationType()]
            [(string) $operation->getCustomer()->getType()]
        );
    }

    /**
     * @param OperationInterface $operation
     *
     * @return RuleInterface
     *
     * @throws Exception
     */
    public function getRule(OperationInterface $operation) : RuleInterface
    {
        if (!$this->ruleExists($operation)) {
            throw new Exception("Commission calculation rule is not set.");
        }

        return $this->rules[(string) $operation->getOperationType()][(string) $operation->getCustomer()->getType()];
    }
}
