<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

use App\Bundle\Common\Domain\Library\TimeSharingReservationText;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\ValueObjectStringTrait;

final class ReservationDuplicityCheckIdent
{
    use ValueObjectStringTrait;

    /**
     * @var string
     */
    private string $value;

    /**
     * @return self
     * @throws InvalidArgumentException
     */
    public static function newId(): self
    {
        return new self(TimeSharingReservationText::id());
    }

    /**
     * @param string $value value
     * @throws InvalidArgumentException
     */
    public function __construct(
        string $value
    ) {
        $this->value = $value;
        if (!self::validate($value)) {
            throw new InvalidArgumentException("[{$value}] ReservationDuplicityCheckIdent 不正な値です。");
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
    public function equals(ReservationDuplicityCheckIdent $obj): bool
    {
        return $this->value === $obj->value;
    }
}
