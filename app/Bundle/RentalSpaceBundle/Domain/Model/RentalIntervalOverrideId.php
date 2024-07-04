<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalIntervalOverrideId
{
    private string $value;

    /**
     * @param string $value value
     * @throws InvalidArgumentException
     */
    public function __construct(
        string $value
    ) {
        $this->value = $value;
        if (!self::validate($value)) {
            throw new InvalidArgumentException("[{$value}] RentalIntervalOverrideId 不正な値です。");
        }
    }

    /**
     * @param string $value value
     * @return bool
     */
    public static function validate(string $value): bool
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
    public function equals(RentalIntervalOverrideId $obj): bool
    {
        return $this->value === $obj->value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
