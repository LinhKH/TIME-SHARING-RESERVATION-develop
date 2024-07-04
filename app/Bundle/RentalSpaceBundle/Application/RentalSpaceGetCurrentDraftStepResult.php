<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGetCurrentDraftStepResult
{
    public int $rentalSpaceId;
    public string $draftStep;
    public bool $isApproval;
    public ?int $rentalPlanId;

    /**
     * @param int $rentalSpaceId rentalSpaceId
     * @param string $draftStep draftStep
     * @param bool $isApproval isApproval
     * @param int|null $rentalPlanId
     */
    public function __construct(
        int $rentalSpaceId,
        string $draftStep,
        bool $isApproval,
        ?int $rentalPlanId
    ) {
        $this->rentalPlanId = $rentalPlanId;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->draftStep = $draftStep;
        $this->isApproval = $isApproval;
    }
}
