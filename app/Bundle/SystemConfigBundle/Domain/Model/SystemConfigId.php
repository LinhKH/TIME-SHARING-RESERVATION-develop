<?php
namespace App\Bundle\SystemConfigBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class SystemConfigId
{
    private string $value;

    /**
     * @param string $value value
     * @throws App\Bundle\Common\Domain\Model\InvalidArgumentException
     */
    public function __construct(
        string $value
    ) {
        $this->value = $value;
        if (!self::validate($value)) {
            throw new InvalidArgumentException("[{$value}] SystemConfigId 不正な値です。");
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
    public function equals(SystemConfigId $obj): bool
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
