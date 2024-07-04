<?php
namespace App\Bundle\CustomerBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class CustomerId
{
    /**
     * @var int
     */
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
            throw new InvalidArgumentException("[{$value}] 不正な値です。");
        }
    }

    /**
     * @param int $value value
     * @return bool
     */
    public static function validate(int $value): bool
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
    public function equals(CustomerId $obj): bool
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
