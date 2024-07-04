<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class AreaId
{
    private int $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(int $value) {
        $this->value = $value;
        if (!self::validate($value)) {
            throw new InvalidArgumentException("[{$value}] AreaId 不正な値です。");
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
     * @param AreaId $areaId
     * @return bool
     */
    public function equals(AreaId $areaId): bool
    {
        return $this->value === $areaId->value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
