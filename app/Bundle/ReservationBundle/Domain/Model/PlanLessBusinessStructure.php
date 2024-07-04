<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class PlanLessBusinessStructure
{
    /** @var int */
    public const ORGANIZATION = 1;
    /** @var int */
    public const INDIVISUAL = 2;

    /** @var array */
    private const VALUES = [
        self::ORGANIZATION => 'organization',
        self::INDIVISUAL => 'indivisual',
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
            throw new InvalidArgumentException("[{$code}] PlanLessBusinessStructure.code 不正な値です。");
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
    public static function fromValue(string $value): PlanLessBusinessStructure
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new PlanLessBusinessStructure($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): PlanLessBusinessStructure
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new PlanLessBusinessStructure($type);
    }
}
