<?php

namespace App\Bundle\TourBundle\Domain\Model;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;

class TourStatus
{
    /**
     * @var string
     */
    private string $status;


    /**
     * @const string
     */
    public const WAIT_FOR_REPLY = 'pending_request';

    /**
     * @const string
     */
    public const USER_CANCEL = 'user_cancel';

    /**
     * @const string
     */
    public const WAIT_FOR_RESPONSE = 'waiting_response_user';

    /**
     * @const string
     */
    public const DATE_AND_TIME_CHANGED = 'change_date_time';

    /**
     * @const string
     */
    public const FIXED_DATE_AND_TIME = 'fix_date_time';

    /**
     * @const string
     */
    public const OBSERVATION_NG = 'observation_NG';


    /**
     * @const array<string, string>
     */
    public const VALUES = [
        self::WAIT_FOR_REPLY => 'wait for owner reply',
        self::WAIT_FOR_RESPONSE => 'wait for user response',
        self::DATE_AND_TIME_CHANGED => 'date and time change',
        self::FIXED_DATE_AND_TIME => 'fixed date and time',
        self::OBSERVATION_NG => 'observation ng',
        self::USER_CANCEL => 'user_cancel'
    ];

    /**
     * TourStatus constructor.
     * @param string $status
     */
    private function __construct(
        string $status
    ) {
        $this->status = $status;
    }

    /**
     * @return string
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
    public function __toString() {
        return "{$this->getStatus()}:{$this->getValue()}";
    }

    /**
     * @param string $value
     * @return TourStatus
     */
    public static function fromValue(string $value): TourStatus
    {
        foreach (self::VALUES as $status => $v)
            if ($v === $value)
            {
                return new TourStatus($status);
            }

        throw  new InvalidArgumentException("[{$value}] 不正な値です。");
    }

    /**
     * @param string $status
     * @return TourStatus
     * @throws InvalidArgumentException
     */
    public static function fromStatus(string $status): TourStatus
    {
        if (!isset(self::VALUES[$status])) {
            throw new InvalidArgumentException("[{$status}] 不正な値です。");
        }

        return new TourStatus($status);
    }

    /**
     * @param NoReason $noReason
     * @return TourStatus
     */
    public static function calcTourStatusByNoReason(NoReason $noReason): TourStatus
    {
        if ($noReason->getNoReason() == NoReason::NOT_POSSIBLE_VISIT_ON_DATE_REQUESTED) {
            return new TourStatus(
                self::DATE_AND_TIME_CHANGED
            );
        }

        return new TourStatus(
            self::OBSERVATION_NG
        );
    }
}

