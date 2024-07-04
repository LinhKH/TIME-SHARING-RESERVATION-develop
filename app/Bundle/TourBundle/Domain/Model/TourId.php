<?php

namespace App\Bundle\TourBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

class TourId
{
    /**
     * @var int
     */
    private int $value;

    /**
     * TourId constructor.
     * @param int $value
     * @throws InvalidArgumentException
     */
    public function __construct(
        int $value
    )
    {
        $this->value = $value;
        if (!self::validate($value)) {
            throw new InvalidArgumentException("[{$value}] TourId 不正な値です。");
        }
    }

    /**
     * @param int $value
     * @return bool
     */
    public function validate(int $value): bool
    {
        if (empty($value)) {
            return false;
        }
        return true;
    }

    /**
     * @param TourId $obj
     * @return bool
     */
    public function equals(TourId $obj): bool
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

