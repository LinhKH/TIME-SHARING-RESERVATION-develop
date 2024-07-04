<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalSpaceRentalIntervalMultiType
{
    /** @var int */
    public const ONE_FRAME = 1;

    /** @var int */
    public const HALF_HOUR = 2;

    /** @var int */
    public const ONE_HOUR = 3;

    /** @var array<int,string> */
    private const VALUES = [
        self::ONE_FRAME => 'One Frame',
        self::HALF_HOUR => '+30 minute',
        self::ONE_HOUR => '+1 hour'
    ];
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
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->getType()}:{$this->getValue()}";
    }

    /**
     * @param string $value value
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromValue(string $value): RentalSpaceRentalIntervalMultiType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new RentalSpaceRentalIntervalMultiType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): RentalSpaceRentalIntervalMultiType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new RentalSpaceRentalIntervalMultiType($type);
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

    /**
     * @return bool
     */
    public function isOneHour(): bool
    {
        return $this->type == self::ONE_HOUR;
    }

    /**
     * @return bool
     */
    public function isHalfHour(): bool
    {
        return $this->type == self::HALF_HOUR;
    }
}
