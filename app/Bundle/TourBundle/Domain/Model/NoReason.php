<?php

namespace App\Bundle\TourBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

class NoReason
{
    /**
     * @var int
     */
    private int $noReason;

    /**
     * @const int
     */
    public const NOT_POSSIBLE_VISIT_ON_DATE_REQUESTED = 1;

    /**
     * @const int
     */
    public const CANNOT_BE_USE_FOR_DESIRED_PURPOSE = 2;

    /**
     * @const int
     */
    public const DATE_REQUESTED_NOT_AVAILABLE = 3;

    /**
     * @const array
     */
    public const VALUES = [
        self::NOT_POSSIBLE_VISIT_ON_DATE_REQUESTED => 'not possible visit on date requested',
        self::CANNOT_BE_USE_FOR_DESIRED_PURPOSE => 'cannot be use for desired purpose',
        self::DATE_REQUESTED_NOT_AVAILABLE => 'date requested not available'
    ];

    /**
     * NoReason constructor.
     * @param int $noReason
     */
    private function __construct(
        int $noReason
    )
    {
        $this->noReason = $noReason;
    }

    /**
     * @return int
     */
    public function getNoReason()
    {
        return $this->noReason;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return self::VALUES[$this->noReason];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "{$this->getNoReason()}: {$this->getValue()}";
    }

    /**
     * @param string $value
     * @return NoReason
     * @throws InvalidArgumentException
     */
    public static function fromValue(string $value): NoReason
    {
        foreach (self::VALUES as $key => $v) {
            if ($v == $value) {
                return new NoReason($key);
            }
        }
        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $noReason
     * @return NoReason
     * @throws InvalidArgumentException
     */
    public static function fromNoReason(int $noReason): NoReason {
        if (isset(self::VALUES[$noReason])) {
            return new NoReason($noReason);
        }
        throw new InvalidArgumentException("[{$noReason}] 不正な値です。");
    }
}
