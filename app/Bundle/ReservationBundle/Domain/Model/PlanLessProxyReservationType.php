<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class PlanLessProxyReservationType
{
    /** @var int */
    public const WEB = 1;
    /** @var int */
    public const NEW_APPLY = 2;
    /** @var int */
    public const EXTENDING = 3;

    /** @var array */
    private const VALUES = [
        self::WEB => 'web',
        self::NEW_APPLY => 'new_apply',
        self::EXTENDING => 'extending'
    ];

    /**
     * @var string
     */
    private string $value;

    /**
     * @var int
     */
    private int $code;

    /**
     * @param int $code code
     * @throws InvalidArgumentException
     */
    public function __construct(
        int $code
    ) {
        $this->code = $code;
        if (!isset(self::VALUES[$code])) {
            throw new InvalidArgumentException("[{$code}] PlanLessProxyReservationType.code 不正な値です。");
        }

        $this->value = self::VALUES[$code];
    }
    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getNote(): string
    {
        return "{$this->code}:{$this->value}";
    }

    /**
     * @param string $value value
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromValue(string $value): PlanLessProxyReservationType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new PlanLessProxyReservationType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): PlanLessProxyReservationType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new PlanLessProxyReservationType($type);
    }
}
