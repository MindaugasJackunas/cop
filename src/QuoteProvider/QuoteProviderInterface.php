<?php

declare(strict_types = 1);

namespace App\QuoteProvider;

use App\ValueObjects\Quotation;

/**
 * Interface QuoteProviderInterface
 */
interface QuoteProviderInterface
{
    /**
     * @return iterable QuotationInterface
     */
    public function getQuotes() : iterable;
}
