<?php

declare(strict_types = 1);

namespace App\OperationProvider;

use App\Factories\OperationFactoryInterface;
use InvalidArgumentException;

/**
 * Class OperationProvider
 */
class OperationProvider implements OperationProviderInterface
{
    /**
     * @var CsvFileReader
     */
    private $csvFileReader;

    /**
     * @var OperationFactoryInterface
     */
    private $operationFactory;

    /**
     * OperationProvider constructor.
     *
     * @param CsvFileReader $csvFileReader
     * @param OperationFactoryInterface $operationFactory
     */
    public function __construct(
        CsvFileReader $csvFileReader,
        OperationFactoryInterface $operationFactory
    ) {
        $this->csvFileReader = $csvFileReader;
        $this->operationFactory = $operationFactory;
    }

    /**
     * @param string $fileName
     *
     * @return iterable
     */
    public function getOperations(string $fileName) : iterable
    {
        $lineNumber = 0;
        foreach ($this->csvFileReader->getCsvLines($fileName) as $csvData) {
            $lineNumber++;

            if (!is_array($csvData)) {
                throw new InvalidArgumentException("Invalid CSV data on line: {$lineNumber}.");
            }

            $operation = $this->operationFactory->makeFromCsvArray($csvData);

            yield $operation;
        }
    }
}
