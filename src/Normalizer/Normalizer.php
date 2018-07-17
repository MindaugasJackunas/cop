<?php

declare(strict_types = 1);

namespace App\Normalizer;

use App\CurrencyExchange\CurrencyExchangeInterface;
use App\Enumerations\Currency;
use App\Enumerations\MandatoryCurrency;
use App\Factories\OperationFactoryInterface;
use App\ValueObjects\CurrencySum;
use App\ValueObjects\CurrencySumInterface;
use App\ValueObjects\OperationInterface;
use Exception;

/**
 * Class Normalizer
 */
class Normalizer implements NormalizerInterface
{
    /**
     * @var Currency
     */
    private $normalizationCurrency;

    /**
     * @var CurrencyExchangeInterface
     */
    private $currencyExchange;

    /**
     * @var OperationFactoryInterface
     */
    private $operationFactory;

    /**
     * CurrencySumNormalizer constructor.
     *
     * @param CurrencyExchangeInterface $currencyExchange
     * @param OperationFactoryInterface $operationFactory
     *
     * @throws Exception
     */
    public function __construct(
        CurrencyExchangeInterface $currencyExchange,
        OperationFactoryInterface $operationFactory
    ) {
        $this->currencyExchange = $currencyExchange;
        $this->operationFactory = $operationFactory;

        $this->normalizationCurrency = new Currency(MandatoryCurrency::getMandatoryCurrency());
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function normalize(OperationInterface $operation) : OperationInterface
    {
        if ($this->isNormalized($operation)) {
            return $operation;
        }

        return $this->operationFactory->make(
            $operation->getDate(),
            $operation->getCustomer(),
            $operation->getOperationType(),
            $this->currencyExchange->exchange($operation->getCurrencySum(), $this->getNormalizationCurrency())
        );
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function denormalize(OperationInterface $operation, float $sum) : float
    {
        if ($this->isNormalized($operation)) {
            return $sum;
        }

        return $this->currencyExchange
            ->exchange(
                self::getNormalizationCurrencySum($sum),
                $operation->getCurrencySum()->getCurrency()
            )->getSum();
    }

    /**
     * @return Currency
     */
    private function getNormalizationCurrency() : Currency
    {
        return $this->normalizationCurrency;
    }

    /**
     * @param float $sum
     *
     * @return CurrencySumInterface
     */
    private function getNormalizationCurrencySum(float $sum) : CurrencySumInterface
    {
        return new CurrencySum($sum, $this->getNormalizationCurrency());
    }

    /**
     * @param OperationInterface $operation
     *
     * @return bool
     */
    private function isNormalized(OperationInterface $operation) : bool
    {
        return (string) $operation->getCurrencySum()->getCurrency() == (string) $this->normalizationCurrency;
    }
}
