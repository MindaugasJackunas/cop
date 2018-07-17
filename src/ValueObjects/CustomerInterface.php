<?php

declare(strict_types = 1);

namespace App\ValueObjects;

use App\Enumerations\CustomerType;

/**
 * Interface CustomerInterface
 */
interface CustomerInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return CustomerType
     */
    public function getType(): CustomerType;
}
