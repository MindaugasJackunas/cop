<?php

declare(strict_types = 1);

namespace App\OperationProvider;

use InvalidArgumentException;
use SplFileObject;

/**
 * Class CsvFileReader
 */
class CsvFileReader
{
    /**
     * @param string $fileName
     *
     * @return iterable
     */
    public function getCsvLines(string $fileName) : iterable
    {
        if (!file_exists($fileName)) {
            throw new InvalidArgumentException("File {$fileName} does not exists.");
        }

        $file = new SplFileObject($fileName);
        $file->setFlags($this->getFlags());

        while (!$file->eof()) {
            yield $file->fgetcsv();
        }
    }

    /**
     * @return int
     */
    private function getFlags() : int
    {
        return SplFileObject::READ_AHEAD
            | SplFileObject::SKIP_EMPTY
            | SplFileObject::DROP_NEW_LINE
            | SplFileObject::READ_CSV;
    }
}
