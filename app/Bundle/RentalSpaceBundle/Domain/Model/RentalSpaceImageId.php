<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Library\TimeSharingReservationText;
use App\Bundle\Common\Domain\Model\ValueObjectStringTrait;
use InvalidArgumentException;

final class RentalSpaceImageId
{
    use ValueObjectStringTrait;

    /**
     * @var string
     */
    private string $value;

    /**
     * @return self
     */
    public static function newId(): self
    {
        return new self(TimeSharingReservationText::id());
    }

    /**
     * @param string $value value
     */
    public function __construct(
        string $value
    ) {
        $this->value = $value;
        if (!self::validate($value)) {
            throw new InvalidArgumentException("[{$value}] RentalSpaceImageId 不正な値です。");
        }
    }

    /**
     * @param string $value value
     * @return bool
     */
    public static function validate(string $value): bool
    {
        if ($value === '') {
            return false;
        }

        return true;
    }

    /**
     * @param self $obj obj
     * @return bool
     */
    public function equals(RentalSpaceImageId $obj): bool
    {
        return $this->value === $obj->value;
    }
}
