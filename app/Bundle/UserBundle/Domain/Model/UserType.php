<?php

namespace App\Bundle\UserBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class UserType
{
    /** @var int */
    public const ADMIN = 1;

    /** @var int */
    public const ORGANIZATION_MEMBER = 2;

    public const ORGANIZATION_MEMBER_2 = 3;

    /** @var array<int,string> */
    private const VALUES = [
        self::ADMIN => 'admin',
        self::ORGANIZATION_MEMBER => 'organization-member',
        self::ORGANIZATION_MEMBER_2 => 'organization',
    ];
    private int $type;

    /**
     * @param int $type type
     */
    private function __construct(
        int $type
    )
    {
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
    public static function fromValue(string $value): UserType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new UserType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     */
    public static function fromType(int $type): UserType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new UserType($type);
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
