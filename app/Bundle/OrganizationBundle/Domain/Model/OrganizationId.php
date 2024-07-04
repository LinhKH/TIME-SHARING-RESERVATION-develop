<?php

namespace App\Bundle\OrganizationBundle\Domain\Model;

use InvalidArgumentException;

final class OrganizationId
{
    private int $value;

    /**
     * @param int $value value
     */
    public function __construct(
        int $value
    ) {
        $this->value = $value;
        if (!self::validate($value)) {
            throw new InvalidArgumentException("[{$value}] OrganizationID 不正な値です。");
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
    public function equals(OrganizationId $obj): bool
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
