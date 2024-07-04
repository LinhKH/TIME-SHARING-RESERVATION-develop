<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalSlotCacheEntryStatusType
{
    /**
     * @var int
     */
    public const RESERVED = 1;

    /**
     * @var int
     */
    public const ORPHANED = 2;

    /**
     * @var int
     */
    public const EXPIRED = 3;

    /**
     * @var int
     */
    public const DENIED = 4;

    /**
     * @var int
     */
    public const PROHIBITED = 5;

    /**
     * @var int
     */
    public const NOT_APPLICABLE = 6;

    /**
     * @var array<int,string>
     */
    public const VALUES = [
        self::RESERVED => 'reserved',
        self::ORPHANED => 'orphaned',
        self::EXPIRED => 'expired',
        self::DENIED => 'denied',
        self::PROHIBITED => 'prohibited',
        self::NOT_APPLICABLE => 'not-applicable',
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
    public static function fromValue(string $value): RentalSlotCacheEntryStatusType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new RentalSlotCacheEntryStatusType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): RentalSlotCacheEntryStatusType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new RentalSlotCacheEntryStatusType($type);
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
