<?php


namespace App\Bundle\TourBundle\Domain\Model;


use App\Bundle\Common\Domain\Model\InvalidArgumentException;

class FixChoiceDate
{
    public const VALUE = [
        'first_choice_date' => [
            'date' => 'first_choice_date',
            'time' => 'first_choice_time'
        ],
        'second_choice_date' => [
            'date' => 'second_choice_date',
            'time' => 'second_choice_time'
        ],
        'third_choice_date' => [
            'date' => 'third_choice_date',
            'time' => 'third_choice_time'
        ]
    ];

    /**
     * @var string
     */
    private string $fixChoiceDate;

    /**
     * @var string
     */
    private string $fixChoiceTime;

    /**
     * FixChoiceDate constructor.
     * @param string $fixChoiceDate
     * @param string $fixChoiceTime
     */
    private function __construct(
        string $fixChoiceDate,
        string $fixChoiceTime
    )
    {
        $this->fixChoiceDate = $fixChoiceDate;
        $this->fixChoiceTime = $fixChoiceTime;
    }

    /**
     * @return string
     */
    public function getFixChoiceDate(): string
    {
        return $this->fixChoiceDate;
    }

    /**
     * @return string
     */
    public function getFixChoiceTime(): string
    {
        return $this->fixChoiceTime;
    }

    /**
     * @param string $value
     * @return FixChoiceDate
     * @throws InvalidArgumentException
     */
    public static function fromValue(string $value) :FixChoiceDate
    {
        foreach (FixChoiceDate::VALUE as $key => $defaultValue) {
            if ($key === $value) {
                return new FixChoiceDate(
                    $defaultValue['date'],
                    $defaultValue['time'],
                );
            }
        }
        throw new InvalidArgumentException("[{$value}] 不正な値です。");
    }
}
