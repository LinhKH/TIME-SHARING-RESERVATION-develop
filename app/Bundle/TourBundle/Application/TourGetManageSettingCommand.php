<?php


namespace App\Bundle\TourBundle\Application;


final class TourGetManageSettingCommand
{
    public ?int $organizationId;

    /**
     * TourGetManageSettingCommand constructor.
     * @param int|null $organizationId
     */
    public function __construct(?int $organizationId)
    {
        $this->organizationId = $organizationId;
    }
}
