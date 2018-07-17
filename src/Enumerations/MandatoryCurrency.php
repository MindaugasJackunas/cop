<?php

declare(strict_types = 1);

namespace App\Enumerations;

use Exception;

/**
 * Class MandatoryCurrency
 */
class MandatoryCurrency extends Currency
{
    const EUR = 'EUR';

    /**
     * @throws Exception
     */
    public static function getMandatoryCurrency()
    {
        if (!isset(self::$currencies[self::EUR])) {
            throw new Exception('Mandatory currency \'' . self::EUR . '\' has to be configured first');
        }

        return self::EUR;
    }
}
