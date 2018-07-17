<?php

declare(strict_types = 1);

namespace App\Processor;

/**
 * Interface ProcessorInterface
 */
interface ProcessorInterface
{
    /**
     * @param string $fileName
     *
     * @return iterable
     */
    public function process(string $fileName) : iterable;
}
