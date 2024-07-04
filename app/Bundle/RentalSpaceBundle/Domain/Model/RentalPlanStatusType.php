<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalPlanStatusType
{
    /**
     * @var int
     */
    public const ACTIVE = 1;

    /**
     * @var int
     */
    public const ARCHIVED = 2;

    /**
     * @var array<int,string>
     */
    private const VALUES = [
        self::ACTIVE => 'active',
        self::ARCHIVED => 'archived'
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
    public static function fromValue(string $value): RentalPlanStatusType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new RentalPlanStatusType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): RentalPlanStatusType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new RentalPlanStatusType($type);
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
