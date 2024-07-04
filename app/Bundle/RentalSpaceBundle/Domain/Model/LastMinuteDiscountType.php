<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class LastMinuteDiscountType
{
    /**
     * @var int
     */
    public const ENABLE_LAST_MINUTE_DISCOUNT = 1;

    /**
     * @var int
     */
    public const DISABLE_LAST_MINUTE_DISCOUNT = 2;

    /**
     * @var array<int,string>
     */
    private const VALUES = [
        self::DISABLE_LAST_MINUTE_DISCOUNT => 'disable',
        self::ENABLE_LAST_MINUTE_DISCOUNT => 'enable',
    ];
    /**
     * @var int
     */
    private int $type;

    /**
     * @param int $type type
     */
    private function __construct(
        int $type
    ) {
        $this->type = $type;
    }

    /**
     * @param string $value value
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromValue(string $value): LastMinuteDiscountType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new LastMinuteDiscountType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): LastMinuteDiscountType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new LastMinuteDiscountType($type);
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return self::VALUES[$this->type];
    }
}
