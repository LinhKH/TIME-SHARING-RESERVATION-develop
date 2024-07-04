<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

class TrackLinkType
{
    /**
     * @var int
     */
    public const RENTAL_SPACE = 1;
    /**
     * @var int
     */
    public const GLOBAL_TYPE = 2;

    /**
     * @var array<int,string>
     */
    private const VALUES = [
        self::RENTAL_SPACE => 'rental_space',
        self::GLOBAL_TYPE => 'global',
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
    public static function fromValue(string $value): TrackLinkType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new TrackLinkType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): TrackLinkType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new TrackLinkType($type);
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
