<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalSpaceImageType
{
    /**
     * @var int
     */
    public const IMAGE = 1;

    /**
     * @var int
     */
    public const IMAGE_PANORAMA = 2;

    /**
     * @var int
     */
    public const IMAGE_FACADE = 3;

    /**
     * @var int
     */
    public const IMAGE_DIRECTION_STATION = 4;

    /**
     * @var int
     */
    public const IMAGE_FLOOR_PLAN = 5;

    /**
     * @var array<int,string>
     */
    public const VALUES = [
        self::IMAGE => 'image',
        self::IMAGE_PANORAMA => 'image_panorama',
        self::IMAGE_FACADE => 'image_facade',
        self::IMAGE_DIRECTION_STATION => 'image_direction_station',
        self::IMAGE_FLOOR_PLAN => 'image_floor_plan',
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
    public static function fromValue(string $value): RentalSpaceImageType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new RentalSpaceImageType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): RentalSpaceImageType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new RentalSpaceImageType($type);
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
