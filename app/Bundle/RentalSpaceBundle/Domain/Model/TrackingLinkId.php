<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class TrackingLinkId
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
            throw new InvalidArgumentException("[{$value}] TrackingLinkId 不正な値です。");
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
    public function equals(TrackingLinkId $obj): bool
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
