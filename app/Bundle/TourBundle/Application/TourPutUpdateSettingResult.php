<?php


namespace App\Bundle\TourBundle\Application;


class TourPutUpdateSettingResult
{
    /**
     * @var bool
     */
    public bool $status;

    /**
     * TourPutUpdateSettingResult constructor.
     * @param bool $status
     */
    public function __construct(bool $status)
    {
        $this->status = $status;
    }
}
