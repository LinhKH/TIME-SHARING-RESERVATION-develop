<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceEquipmentConferenceInformationCommand
{

    public ?bool $whiteboard;
    public ?bool $copierOrMultifunctionMachine;
    public ?bool $moderator;

    /**
     * Equipment Information : Conference equipment
     *
     * @param bool|null $whiteboard
     * @param bool|null $copierOrMultifunctionMachine
     * @param bool|null $moderator
     */

    public function __construct(
        ?bool $whiteboard,
        ?bool $copierOrMultifunctionMachine,
        ?bool $moderator
    ){
        $this->moderator = $moderator;
        $this->copierOrMultifunctionMachine = $copierOrMultifunctionMachine;
        $this->whiteboard = $whiteboard;
    }
}
