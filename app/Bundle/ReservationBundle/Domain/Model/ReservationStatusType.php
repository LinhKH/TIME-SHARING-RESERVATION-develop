<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class ReservationStatusType
{
    /** @var int */
    public const RESERVARION_STATUS_PENDING = 1;


    /** @var array<int,string> */
    private const VALUES = [
        self::RESERVARION_STATUS_PENDING => 'pending-approval-from-owner'
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
    public static function fromValue(string $value): ReservationStatusType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new ReservationStatusType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): ReservationStatusType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new ReservationStatusType($type);
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
