<?php
namespace App\Bundle\UserBundle\Domain\Model;

final class GenderType
{
    /**
     * @var int
     */
    public const MALE = 1;
    /**
     * @var int
     */
    public const FEMALE = 2;

    /**
     * @var array<int,string>
     */
    private const VALUES = [
        self::MALE => 'male',
        self::FEMALE => 'female',
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
    public static function fromValue(string $value): GenderType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new GenderType($type);
            }
        }

        // throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     */
    public static function fromType(int $type): GenderType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new GenderType($type);
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
