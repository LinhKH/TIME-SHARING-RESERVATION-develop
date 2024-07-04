<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class ConfigCsvTargetType
{
    /**
     * @var int
     */
    public const SPACES = 1;
    public const CUSTOMERS = 2;
    public const CONTACT_FORM = 3;
    public const CATERING_INQUIRY_FORM = 4;
    public const USERS = 5;
    public const ORGANIZATIONS = 6;
    public const INQUIRIES = 7;
    public const YAKATABUNE_INQUIRY = 8;
    public const SPACE_SEARCH_FORM = 9;
    public const RESERVATIONS = 10;
    public const RENTAL_SPACE_REVIEWS = 11;

    /**
     * @var array<int,string>
     *
     */
    private const VALUES = [
        self::SPACES => 'spaces',
        self::CUSTOMERS => 'customers',
        self::CONTACT_FORM => 'contact-form',
        self::CATERING_INQUIRY_FORM => 'catering-inquiry-form',
        self::USERS => 'users',
        self::ORGANIZATIONS => 'organizations',
        self::INQUIRIES => 'inquiries',
        self::YAKATABUNE_INQUIRY => 'yakatabune-inquiry',
        self::SPACE_SEARCH_FORM => 'space-search-form',
        self::RESERVATIONS => 'reservations',
        self::RENTAL_SPACE_REVIEWS => 'rental-space-reviews'
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
    public static function fromValue(string $value): ConfigCsvTargetType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new ConfigCsvTargetType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): ConfigCsvTargetType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new ConfigCsvTargetType($type);
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
