<?php
namespace App\Bundle\UserBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class UserId
{
    /**
     * @var int
     */
    private int $value;

    /**
     * @param int $value value
     */
    public function __construct(
        int $value
    ) {
        $this->value = $value;
        if (!self::validate($value)) {
            throw new InvalidArgumentException("[{$value}] 不正な値です。");
        }
    }

    /**
     * @param int $value value
     * @return bool
     */
    public static function validate(int $value)
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
    public function equals(UserId $obj): bool
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
