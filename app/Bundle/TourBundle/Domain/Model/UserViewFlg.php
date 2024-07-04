<?php

namespace App\Bundle\TourBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

class UserViewFlg
{
    /**
     * @const int
     */
    public const HIDE = 0;

    /**
     * @const int
     */
    public const SHOW = 1;

    /**
     * @const array<int, string>
     */
    public const VALUES = [
        self::HIDE => 'hide',
        self::SHOW => 'show'
    ];

    /**
     * @var int
     */
    private int $status;

    /**
     * UserViewFlg constructor.
     * @param int $status
     */
    private function __construct(
      int $status
    ) {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return self::VALUES[$this->status];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->getStatus()}:{$this->getValue()}";
    }

    /**
     * @param string $value
     * @return UserViewFlg
     */
    public static function fromValue(string $value): UserViewFlg
    {
        foreach (self::VALUES as $status => $v) {
            if ($v === $value) {
                return new UserViewFlg($status);
            }
        }
        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $status
     * @return UserViewFlg
     */
    public static function fromStatus(int $status): UserViewFlg
    {
        if (!isset(self::VALUES[$status])) {
            throw new InvalidArgumentException("[{$status}] 不正な値です。");
        }
        return new UserViewFlg($status);
    }

}

