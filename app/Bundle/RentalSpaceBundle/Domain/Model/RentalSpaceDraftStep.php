<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalSpaceDraftStep
{
    /** @var int */
    public const GENERAL = 1;
    /** @var int */
    public const IMAGE = 2;
    /** @var int */
    public const EQUIPMENT_INFORMATION = 3;
    /** @var int */
    public const BOOKING_SYSTEM = 4;
    /** @var int */
    public const RESERVATION_OPTION = 5;
    /** @var int */
    public const PLAN_CREATION = 6;
    /** @var int */
    public const PLAN_CREATE_RESERVATION_FRAME = 7;
    /** @var int */
    public const PAGE_AND_EMAIL_MESSAGE = 8;
    /** @var int */
    public const APPROVE = 9;

    /** @var array */
    private const VALUES = [
        self::GENERAL => 'general',
        self::IMAGE => 'images',
        self::EQUIPMENT_INFORMATION => 'equipment-information',
        self::BOOKING_SYSTEM => 'booking-system',
        self::RESERVATION_OPTION => 'reservation-options',
        self::PLAN_CREATION => 'plan-creation',
        self::PLAN_CREATE_RESERVATION_FRAME => 'plan-create-reservation-frame',
        self::PAGE_AND_EMAIL_MESSAGE => 'page-and-email-message',
        self::APPROVE => 'approve',
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
            throw new InvalidArgumentException("[{$code}] RentalSpaceDraftStep.code 不正な値です。");
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
    public static function fromValue(string $value): RentalSpaceDraftStep
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new RentalSpaceDraftStep($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): RentalSpaceDraftStep
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new RentalSpaceDraftStep($type);
    }

    public function nextStep(): int
    {
        if ($this->code === self::GENERAL) {
            return self::IMAGE;
        }

        if ($this->code === self::IMAGE) {
            return self::EQUIPMENT_INFORMATION;
        }

        if ($this->code === self::EQUIPMENT_INFORMATION) {
            return self::BOOKING_SYSTEM;
        }

        if ($this->code === self::BOOKING_SYSTEM) {
            return self::RESERVATION_OPTION;
        }

        if ($this->code === self::RESERVATION_OPTION) {
            return self::PLAN_CREATION;
        }

        if ($this->code === self::PLAN_CREATION) {
            return self::PLAN_CREATE_RESERVATION_FRAME;
        }

        if ($this->code === self::PLAN_CREATE_RESERVATION_FRAME) {
            return self::PAGE_AND_EMAIL_MESSAGE;
        }

        return self::APPROVE;

    }

}
