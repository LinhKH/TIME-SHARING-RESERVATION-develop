<?php


namespace App\Bundle\RentalSpaceBundle\Domain\Model;


use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class PageAndEmailMessageType
{
    /**
     * @const int
     */
    public const EMAIL_MESSAGE = 1;

    /**
     * @const int
     */
    public const PAGE = 2;

    /**
     * @const array<int, string>
     */
    public const VALUES = [
        self::EMAIL_MESSAGE => 'email-message',
        self::PAGE => 'page'
    ];

    /**
     * @var int
     */
    private int $type;

    /**
     * PageAndEmailMessageType constructor.
     * @param int $type
     */
    private function __construct(int $type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType(): int {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string {
        return self::VALUES[$this->type];
    }

    /**
     * @param int $type
     * @return PageAndEmailMessageType
     * @throws InvalidArgumentException
     */
    public static function fromType(int $type): PageAndEmailMessageType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }
        return new PageAndEmailMessageType($type);
    }

    /**
     * @param string $inputValue
     * @return PageAndEmailMessageType
     * @throws InvalidArgumentException
     */
    public static function fromValue(string $inputValue): PageAndEmailMessageType
    {
        foreach (self::VALUES as $key => $value) {
            if ($value == $inputValue) {
                return new PageAndEmailMessageType($key);
            }
        }

        throw new InvalidArgumentException("[{$inputValue}] 不正な値です。");
    }

    /**
     * @return bool
     */
    public function isEmailMessage(): bool
    {
        if ($this->type == self::EMAIL_MESSAGE) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isPage(): bool
    {
        if ($this->type == self::PAGE) {
            return true;
        }
        return false;
    }
}
