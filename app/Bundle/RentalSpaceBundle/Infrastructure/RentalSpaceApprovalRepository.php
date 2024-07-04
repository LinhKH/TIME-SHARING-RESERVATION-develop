<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceApprovalRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceApproval;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Models\RentalSpace as ModelRentalSpace;

class RentalSpaceApprovalRepository implements IRentalSpaceApprovalRepository
{
    /**
     * Update status for Space
     *
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     * @throws InvalidArgumentException
     */
    public function updateRentalSpaceApproval(RentalSpace $rentalSpace): array
    {
        // TODO: Implement updateRentalSpaceBookingSystem() method.
        $rentalSpaceModel = ModelRentalSpace::findOrFail($rentalSpace->getRentalSpaceId()->getValue());
        $rentalSpaceModel->update([
            'draft_step' => $rentalSpace->getDraftStep()->nextStep(),
            'status' => $rentalSpace->getRentalSpaceApproval()->getStatus()
        ]);
        $rentalSpaceModel->save();
        return [new RentalSpaceId($rentalSpaceModel->id), new RentalSpaceDraftStep($rentalSpaceModel->draft_step)];
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceApproval|null
     */
    public function findBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalSpaceApproval
    {
        $entities = ModelRentalSpace::findOrFail($rentalSpaceId->getValue());
        if (!$entities) {
            return null;
        }
        return new RentalSpaceApproval(
            $rentalSpaceId,
            $entities->status
        );
    }
}
