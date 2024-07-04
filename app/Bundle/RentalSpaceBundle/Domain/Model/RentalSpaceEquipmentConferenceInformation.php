<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceEquipmentConferenceInformation
{
    private ?bool $whiteboard;
    private ?bool $copierOrMultifunctionMachine;
    private ?bool $moderator;

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

    /**
     * @return bool|null
     */
    public function getWhiteboard(): ?bool
    {
        return $this->whiteboard;
    }

    /**
     * @return bool|null
     */
    public function getCopierOrMultifunctionMachine(): ?bool
    {
        return $this->copierOrMultifunctionMachine;
    }

    /**
     * @return bool|null
     */
    public function getModerator(): ?bool
    {
        return $this->moderator;
    }


}
