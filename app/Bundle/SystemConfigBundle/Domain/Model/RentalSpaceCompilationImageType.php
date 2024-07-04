<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class RentalSpaceCompilationImageType
{
    private int $type;

    /**
     * @const int
     */
    public const HEADER_FOR_PC = 1;

    /**
     * @const int
     */
    public const LIST_FOR_PC = 2;

    /**
     * @const int
     */
    public const HEADER_FOR_MOBILE = 3;

    /**
     * @const int
     */
    public const MOBILE_LIST = 4;

    /**
     * @array<int, string>
     */
    public const VALUES = [
        self::HEADER_FOR_PC => 'header-for-pc',
        self::LIST_FOR_PC => 'list-for-pc',
        self::HEADER_FOR_MOBILE => 'header-for-mobile',
        self::MOBILE_LIST => 'mobile-list'
    ];

    /**
     * RentalSpaceCompilationImageType constructor.
     * @param int $type
     */
    private function __construct(
        int $type
    )
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return self::VALUES[$this->type];
    }

    /**
     * @param int $type
     * @return RentalSpaceCompilationImageType
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): RentalSpaceCompilationImageType
    {
        if (isset(self::VALUES[$type])) {
            return new RentalSpaceCompilationImageType($type);
        }
        throw new InvalidArgumentException("[{$type}] 不正な値です。");
    }

    /**
     * @param string $value
     * @return RentalSpaceCompilationImageType
     * @throws InvalidArgumentException
     */
    public static function fromValue(string $value): RentalSpaceCompilationImageType
    {
        foreach (self::VALUES as $key => $v) {
            if ($v === $value) {
                return new RentalSpaceCompilationImageType($key);
            }
        }
        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }
}
