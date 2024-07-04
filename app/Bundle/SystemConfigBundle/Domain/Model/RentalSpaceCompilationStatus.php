<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalSpaceCompilationStatus
{
    /**
     * @const int
     */
    public const INACTIVE = 0;

    /**
     * @const int
     */
    public const ACTIVE = 1;

    /**
     * @const array<int, string>
     */
    public const VALUES = [
        self::INACTIVE => 'inactive',
        self::ACTIVE => 'active'
    ];

    /**
     * @var int
     */
    private int $status;

    /**
     * RentalSpaceCompilationStatus constructor.
     * @param int $status
     */
    private function __construct(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return self::VALUES[$this->status];
    }

    /**
     * @param string $value
     * @return RentalSpaceCompilationStatus
     * @throws InvalidArgumentException
     */
    public static function fromValue(string $value): RentalSpaceCompilationStatus
    {
        foreach (self::VALUES as $key => $v) {
            if ($v == $value) {
                return new RentalSpaceCompilationStatus($key);
            }
        }
        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $status
     * @return RentalSpaceCompilationStatus
     * @throws InvalidArgumentException
     */
    public static function fromStatus(int $status): RentalSpaceCompilationStatus
    {
        if (!isset(self::VALUES[$status])) {
            throw new InvalidArgumentException("[{$status}] 不正な値です。");
        }
        return new RentalSpaceCompilationStatus($status);
    }
}
