<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalPlanType
{
    /**
     * @var int
     */
    public const INSTANT_RESERVATION = 1;

    /**
     * @var int
     */
    public const RESERVATION_REQUEST = 2;

    /**
     * @var array<int,string>
     */
    private const VALUES = [
        self::INSTANT_RESERVATION => 'instant-reservation',
        self::RESERVATION_REQUEST => 'reservation-request'
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
    public static function fromValue(string $value): RentalPlanType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new RentalPlanType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): RentalPlanType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new RentalPlanType($type);
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
