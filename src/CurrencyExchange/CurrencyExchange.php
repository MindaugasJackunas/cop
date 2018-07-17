<?php

declare(strict_types = 1);

namespace App\CurrencyExchange;

use App\Enumerations\Currency;
use App\Factories\CurrencySumFactoryInterface;
use App\Factories\PairFactoryInterface;
use App\QuoteProvider\QuoteProviderInterface;
use App\ValueObjects\CurrencySumInterface;
use App\ValueObjects\QuotationInterface;
use Exception;

/**
 * Class CurrencyExchange
 */
class CurrencyExchange implements CurrencyExchangeInterface
{
    /**
     * @var array
     */
    private $exchangeRates = [];

    /**
     * @var CurrencySumFactoryInterface
     */
    private $currencySumFactory;

    /**
     * @var PairFactoryInterface
     */
    private $pairFactory;

    /**
     * CurrencyExchange constructor.
     *
     * @param QuoteProviderInterface $quoteProvider
     * @param CurrencySumFactoryInterface $currencySumFactory
     * @param PairFactoryInterface $pairFactory
     */
    public function __construct(
        QuoteProviderInterface $quoteProvider,
        CurrencySumFactoryInterface $currencySumFactory,
        PairFactoryInterface $pairFactory
    ) {
        $this->currencySumFactory = $currencySumFactory;
        $this->pairFactory = $pairFactory;

        $this->setupQuotes($quoteProvider->getQuotes());
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function exchange(CurrencySumInterface $currencySum, Currency $toCurrency) : CurrencySumInterface
    {
        $this->assertRateExists($currencySum->getCurrency(), $toCurrency);

        $exchangedSum = $currencySum->getSum() * $this->getExchangeRate($currencySum->getCurrency(), $toCurrency);

        return $this->currencySumFactory->make($exchangedSum, $toCurrency);
    }

    /**
     * @param Currency $fixedCurrency
     * @param Currency $variableCurrency
     *
     * @throws Exception
     */
    public function assertRateExists(Currency $fixedCurrency, Currency $variableCurrency)
    {
        if (!$this->rateExists($fixedCurrency, $variableCurrency)) {
            $pair = $this->pairFactory->make($fixedCurrency, $variableCurrency);
            throw new Exception("Exchange rate for '{$pair}' has not been provided.");
        }
    }

    /**
     * @param Currency $fixedCurrency
     * @param Currency $variableCurrency
     *
     * @return float
     */
    public function getExchangeRate(Currency $fixedCurrency, Currency $variableCurrency) : float
    {
        return $this->exchangeRates[(string) $fixedCurrency][(string) $variableCurrency];
    }

    /**
     * @param Currency $fixedCurrency
     * @param Currency $variableCurrency
     *
     * @return bool
     */
    public function rateExists(Currency $fixedCurrency, Currency $variableCurrency) : bool
    {
        return isset($this->exchangeRates[(string) $fixedCurrency])
            && isset($this->exchangeRates[(string) $fixedCurrency][(string) $variableCurrency]);
    }

    /**
     * @param QuotationInterface[] $quotes
     */
    private function setupQuotes(array $quotes)
    {
        // keep missing rates and process at the end
        $missingRates = [];

        foreach ($quotes as $quote) {
            $fixedCurrency = (string) $quote->getFixedCurrency();
            $variableCurrency = (string) $quote->getVariableCurrency();
            $rate = $quote->getRate();

            $missingRates = $this->handleRates($fixedCurrency, $variableCurrency, $rate, $missingRates);
            $missingRates = $this->handleRates($variableCurrency, $fixedCurrency, 1 / $rate, $missingRates);
        }

        $this->processMissingRates($missingRates);
    }

    /**
     * @param array $missingRates
     */
    private function processMissingRates(array $missingRates)
    {
        while (count($missingRates) > 0) {
            foreach ($missingRates as $fixedCurrency => $missingRate) {
                foreach ($missingRate as $variableCurrency => $rate) {
                    $missingRates = $this->handleRates($fixedCurrency, $variableCurrency, $rate, $missingRates);
                    $missingRates = $this->handleRates($variableCurrency, $fixedCurrency, 1 / $rate, $missingRates);
                }
            }
        }
    }

    /**
     * Adds currency pair to exchange array and keeps missing rates updated.
     *
     * @param string $fixedCurrency
     * @param string $variableCurrency
     * @param float $rate
     * @param array $missingRates
     *
     * @return array
     */
    private function handleRates(
        string $fixedCurrency,
        string $variableCurrency,
        float $rate,
        array $missingRates
    ) : array {
        $missingRates = $this->cleanupMissingRates($missingRates, $fixedCurrency, $variableCurrency);
        return array_merge($missingRates, $this->addRate($fixedCurrency, $variableCurrency, $rate));
    }

    /**
     * @param array $missingRates
     * @param string $fixedCurrency
     * @param string $variableCurrency
     *
     * @return array
     */
    private function cleanupMissingRates(array $missingRates, string $fixedCurrency, string $variableCurrency) : array
    {
        if (isset($missingRates[$fixedCurrency][$variableCurrency])) {
            unset($missingRates[$fixedCurrency][$variableCurrency]);
        }

        if (isset($missingRates[$fixedCurrency])) {
            if (count($missingRates[$fixedCurrency]) === 0) {
                unset($missingRates[$fixedCurrency]);
            }
        }

        return $missingRates;
    }

    /**
     * @param string $fixedCurrency
     * @param string $variableCurrency
     * @param float $rate
     *
     * @return array
     */
    private function addRate(string $fixedCurrency, string $variableCurrency, float $rate) : array
    {
        $candidateRates = [];

        if (!isset($this->exchangeRates[$fixedCurrency])) {
            $this->exchangeRates[$fixedCurrency] = [];
        } else {
            $candidateRates = $this->getMissingRates($fixedCurrency, $variableCurrency, $rate);
        }

        if (!isset($this->exchangeRates[$fixedCurrency][$variableCurrency])) {
            $this->exchangeRates[$fixedCurrency][$variableCurrency] = $rate;
        }

        return $candidateRates;
    }

    /**
     * Generates potential rates by looking at current exchange rate array.
     *
     * @param $fixedCurrency
     * @param string $variableCurrency
     * @param float $rate
     *
     * @return array
     */
    private function getMissingRates($fixedCurrency, string $variableCurrency, float $rate) : array
    {
        $candidateRates = [];

        foreach ($this->exchangeRates[$fixedCurrency] as $candidateKey => $fixedCurrencyRate) {
            // ignore when currencies are the same and when rate already exists
            if ($variableCurrency !== $candidateKey
                && !isset($this->exchangeRates[$variableCurrency][$candidateKey])
            ) {
                $candidateRates[$variableCurrency][$candidateKey] = $fixedCurrencyRate / $rate;
                $candidateRates[$candidateKey][$variableCurrency] = $rate / $fixedCurrencyRate;
            }
        }

        return $candidateRates;
    }
}
