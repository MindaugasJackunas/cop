<?php

declare(strict_types = 1);

namespace App\Normalizer;

use App\ValueObjects\OperationInterface;

/**
 * Interface NormalizerInterface
 */
interface NormalizerInterface
{
    /**
     * @param OperationInterface $operation
     *
     * @return OperationInterface
     */
    public function normalize(OperationInterface $operation) : OperationInterface;

    /**
     * @param OperationInterface $operation
     *
     * @param float $sum
     *
     * @return float
     */
    public function denormalize(OperationInterface $operation, float $sum) : float;
}
