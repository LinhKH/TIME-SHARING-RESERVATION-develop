<?php
namespace App\Bundle\UserBundle\Domain\Model;

use App\Bundle\ Common\Domain\Model\InvalidArgumentException;

final class AuthorityType
{
    /**
     * @var int
     */
    public const ORGANIZATION_BUNDLE = 1;

    /**
     * @var int
     */
    public const INQUIRY_BUNDLE = 2;

    /**
     * @var int
     */
    public const USER_BUNDLE = 3;

    /**
     * @var int
     */
    public const RESERVATION_BUNDLE = 4;

    /**
     * @var int
     */
    public const RESERVATION_BUNDLE_COMPENSATION_CHARGE  = 5;

    /**
     * @var int
     */
    public const CUSTOMER_BUNDLE = 6;

    /**
     * @var int
     */
    public const RENTAL_SPACE_BUNDLE = 7;

    /**
     * @var array<int,string>
     */
    private const VALUES = [
        self::ORGANIZATION_BUNDLE => 'organization_bundle',
        self::INQUIRY_BUNDLE => 'inquiry_bundle',
        self::USER_BUNDLE => 'user_bundle',
        self::RESERVATION_BUNDLE => 'reservation_bundle',
        self::RESERVATION_BUNDLE_COMPENSATION_CHARGE => 'reservation_bundle_compensation_charge',
        self::CUSTOMER_BUNDLE => 'customer_bundle',
        self::RENTAL_SPACE_BUNDLE => 'rental_space_bundle',
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
    public static function fromValue(string $value): AuthorityType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new AuthorityType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     */
    public static function fromType(int $type): AuthorityType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new AuthorityType($type);
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
