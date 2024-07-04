<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalSpaceCompilationId
{
    /**
     * @var int
     */
    private int $value;

    /**
     * RentalSpaceCompilationId constructor.
     * @param int $value
     * @throws InvalidArgumentException
     */
    public function __construct(
        int $value
    ) {
        $this->value = $value;
        if (!self::validate($value)) {
            throw new InvalidArgumentException("[{$value}] RentalSpaceCompilationId 不正な値です。");
        }
    }

    /**
     * @param int $value
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
     * @param RentalSpaceCompilationId $obj
     * @return bool
     */
    public function equals(RentalSpaceCompilationId $obj): bool
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
