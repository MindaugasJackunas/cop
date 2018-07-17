<?php

declare(strict_types = 1);

namespace App\OperationProvider;

/**
 * Interface OperationProviderInterface
 */
interface OperationProviderInterface
{
    /**
     * Retrieves operation iterator.
     *
     * @param string $fileName
     *
     * @return iterable
     */
    public function getOperations(string $fileName) : iterable;
}
