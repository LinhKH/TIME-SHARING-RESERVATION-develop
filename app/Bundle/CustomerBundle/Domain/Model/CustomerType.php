<?php
namespace App\Bundle\CustomerBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class CustomerType
{
    /** @var int */
    public const PERMANENT = 1;

    /** @var int */
    public const TRANSIENT = 2;

    /** @var int */
    public const DELETED = 3;

    /** @var array<int,string> */
    private const VALUES = [
        self::PERMANENT => 'permanent',
        self::TRANSIENT => 'transient',
        self::DELETED => 'deleted',
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
    public static function fromValue(string $value): CustomerType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new CustomerType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     */
    public static function fromType(int $type): CustomerType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new CustomerType($type);
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
