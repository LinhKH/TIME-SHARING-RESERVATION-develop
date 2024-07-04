<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use InvalidArgumentException;

final class RentalSpaceAgreeingToTermsValue
{

    /** @var int */
    public const ON = 1;
    /** @var int */
    public const OFF = 2;

    /** @var array<int,string> */
    private const VALUES = [
        self::OFF => 'disabled',
        self::ON => 'enabled',
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
    public static function fromValue(string $value): RentalSpaceAgreeingToTermsValue
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new RentalSpaceAgreeingToTermsValue($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     */
    public static function fromType(int $type): RentalSpaceAgreeingToTermsValue
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new RentalSpaceAgreeingToTermsValue($type);
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
