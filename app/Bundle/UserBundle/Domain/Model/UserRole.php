<?php
namespace App\Bundle\UserBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class UserRole
{
    /** @var int */
    public const ORGANIZATION = 1;
    /** @var int */
    public const INQUIRY = 2;
    /** @var int */
    public const USER = 3;
    /** @var int */
    public const RESERVATION = 4;
    /** @var int */
    public const RESERVATION_COMPENSATION_CHARGE = 5;
    /** @var int */
    public const CUSTOMER = 6;
    /** @var int */
    public const RENTAL_SPACE = 7;
    /** @var int */
    public const ALL = 8;
    /** @var int */
    public const SUPERVISOR = 9;
    /** @var int */
    public const ADMIN = 10;

    /** @var array<int,string> */
    private const VALUES = [
        self::ORGANIZATION => 'organization',
        self::INQUIRY => 'inquiry',
        self::USER => 'user',
        self::RESERVATION => 'reservation',
        self::RESERVATION_COMPENSATION_CHARGE => 'reservation_compensation_charge',
        self::CUSTOMER => 'customer',
        self::RENTAL_SPACE => 'rental_space',
        self::ALL => 'all',
        self::SUPERVISOR => 'supervisor',
        self::ADMIN => 'admin',
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
    public static function fromValue(string $value): UserRole
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new UserRole($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     */
    public static function fromType(int $type): UserRole
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new UserRole($type);
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
