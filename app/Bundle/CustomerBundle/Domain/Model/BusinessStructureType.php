<?php
namespace App\Bundle\CustomerBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

final class BusinessStructureType
{
    /**
     * @var int
     */
    public const ORGANIZATION = 1;
    /**
     * @var int
     */
    public const INDIVIDUAL = 2;

    /**
     * @var array<int,string>
     */
    private const VALUES = [
        self::ORGANIZATION => 'organization',
        self::INDIVIDUAL => 'individual',
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
    public static function fromValue(string $value): BusinessStructureType
    {
        foreach (self::VALUES as $type => $v) {
            if ($v === $value) {
                return new BusinessStructureType($type);
            }
        }

        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param int $type type
     * @return self
     */
    public static function fromType(int $type): BusinessStructureType
    {
        if (!isset(self::VALUES[$type])) {
            throw new InvalidArgumentException("[{$type}] 不正な値です。");
        }

        return new BusinessStructureType($type);
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
