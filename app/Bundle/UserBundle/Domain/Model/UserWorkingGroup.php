<?php
namespace App\Bundle\UserBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class UserWorkingGroup
{
    /** @var int */
    public const BILLING = 1;

    /** @var array<int,string> */
    private const VALUES = [
        self::BILLING => 'billing',
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
    public static function fromValue(string $value): UserWorkingGroup
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new UserWorkingGroup($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     */
    public static function fromType(int $type): UserWorkingGroup
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new UserWorkingGroup($type);
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
