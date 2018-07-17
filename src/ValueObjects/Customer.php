<?php

declare(strict_types = 1);

namespace App\ValueObjects;

use App\Enumerations\CustomerType;

/**
 * Class Customer
 */
class Customer implements CustomerInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var CustomerType
     */
    private $type;

    /**
     * Customer constructor.
     *
     * @param int $id
     * @param CustomerType $type
     */
    public function __construct(int $id, CustomerType $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return CustomerType
     */
    public function getType(): CustomerType
    {
        return $this->type;
    }
}
