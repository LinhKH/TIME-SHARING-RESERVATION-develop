<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalSpaceRentalIntervalHolidayApplicabilityType
{
    public const NONE = 0;
    /** @var int */
    public const HOLIDAY_IRRELEVANT = 1;

    /** @var int */
    public const HOLIDAY_ONLY = 2;

    /** @var int */
    public const NON_HOLIDAY_ONLY = 3;

    /** @var array<int,string> */
    private const VALUES = [
        self::HOLIDAY_IRRELEVANT => 'holiday-irrelevant',
        self::HOLIDAY_ONLY => 'holiday-only',
        self::NON_HOLIDAY_ONLY => 'non-holiday-only',
        self::NONE => null,
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
     */
    public static function fromValue(string $value): RentalSpaceRentalIntervalHolidayApplicabilityType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new RentalSpaceRentalIntervalHolidayApplicabilityType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): RentalSpaceRentalIntervalHolidayApplicabilityType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new RentalSpaceRentalIntervalHolidayApplicabilityType($type);
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
