<?php

declare(strict_types = 1);

namespace App\QuoteProvider;

use App\Factories\QuoteFactoryInterface;
use App\ValueObjects\QuotationInterface;

/**
 * Class ConfigQuoteProvider
 */
class ConfigQuoteProvider implements QuoteProviderInterface
{
    /**
     * Associative array of pair and quotes.
     */
    const QUOTES = [
        'EUR/USD' => 1.1497,
        'EUR/JPY' => 129.53
    ];

    /**
     * @var QuotationInterface[]
     */
    private static $cachedQuotes;

    /**
     * @var QuoteFactoryInterface
     */
    private $quoteFactory;

    /**
     * ConfigQuoteProvider constructor.
     */
    public function __construct(QuoteFactoryInterface $quoteFactory)
    {
        $this->quoteFactory = $quoteFactory;
    }

    /**
     * @return QuotationInterface[]
     */
    public function getQuotes() : iterable
    {
        if (!isset(self::$cachedQuotes)) {
            // TODO: load from configuration file

            self::$cachedQuotes = array_map(function ($pair, $rate) {
                return $this->quoteFactory->make($pair, $rate);
            }, array_keys(self::QUOTES), self::QUOTES);
        }

        return self::$cachedQuotes;
    }
}
