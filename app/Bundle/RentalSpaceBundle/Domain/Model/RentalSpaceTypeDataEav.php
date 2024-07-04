<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalSpaceTypeDataEav
{
    /**
     * @var int
     */
    public const GENERAL = 1;

    /**
     * @var int
     */
    public const EQUIPMENT_INFORMATION = 2;


    /**
     * @var int
     */
    public const BOOKING_SYSTEM = 3;


    /**
     * @var array<int,string>
     */
    public const VALUES = [
        self::GENERAL => 'general',
        self::EQUIPMENT_INFORMATION => 'equipment_information',
        self::BOOKING_SYSTEM => 'booking_system',
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
    public static function fromValue(string $value): RentalSpaceTypeDataEav
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new RentalSpaceTypeDataEav($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): RentalSpaceTypeDataEav
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new RentalSpaceTypeDataEav($type);
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
