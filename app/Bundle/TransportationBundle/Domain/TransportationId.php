<?php

namespace App\Bundle\TransportationBundle\Domain;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

class TransportationId
{
    private int $value;

    /**
     * @param int $value value
     * @throws InvalidArgumentException
     */
    public function __construct(
        int $value
    ) {
        $this->value = $value;
        if (!self::validate($value)) {
            throw new InvalidArgumentException("[{$value}] TransportationId 不正な値です。");
        }
    }

    /**
     * @param int $value value
     * @return bool
     */
    public static function validate(int $value): bool
    {
        if (empty($value)) {
            return false;
        }

        return true;
    }

    /**
     * @param self $obj obj
     * @return bool
     */
    public function equals(TransportationId $obj): bool
    {
        return $this->value === $obj->value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
