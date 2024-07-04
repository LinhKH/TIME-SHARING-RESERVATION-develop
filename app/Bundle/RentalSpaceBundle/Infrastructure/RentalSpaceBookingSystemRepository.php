<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceBookingSystemRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceAgreeingToTermsValue;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceBookingSystem;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceBookingSystemAdvanced;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Models\RentalSpace as ModelRentalSpace;
use App\Models\RentalSpaceEav as ModelRentalSpaceEav;

class RentalSpaceBookingSystemRepository implements IRentalSpaceBookingSystemRepository
{

    /**
     * Create Space Booking System
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     * @throws InvalidArgumentException
     */
    public function createRentalSpaceBookingSystem(RentalSpace $rentalSpace): array
    {
        // TODO: Implement createRentalSpaceBookingSystem() method.
        $dataEav = [
            "bookingSystem__agreeingToTerms" => $rentalSpace->getRentalSpaceBookingSystem()->getAgreeingToTerms()->getValue()
        ];
        foreach ($dataEav as $key => $value) {
            ModelRentalSpaceEav::create([
                'namespace' => $rentalSpace->getRentalSpaceId()->getValue(),
                'attribute' => $key,
                'value' => $value,
                'type_step' => 'booking_system'
            ]);
        }
        $rentalSpaceModel = ModelRentalSpace::findOrFail($rentalSpace->getRentalSpaceId()->getValue());
        $rentalSpaceModel->update([
            'draft_step' => $rentalSpace->getDraftStep()->nextStep()
        ]);
        $rentalSpaceModel->save();
        return [new RentalSpaceId($rentalSpaceModel->id), new RentalSpaceDraftStep($rentalSpaceModel->draft_step)];
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return array{RentalSpaceBookingSystem|string}|null
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?array
    {
        // TODO: Implement findById() method.
        $space = ModelRentalSpace::find($rentalSpaceId->getValue());
        $entities = ModelRentalSpaceEav::where('namespace', $rentalSpaceId->getValue())->get()->toArray();
        if (!$entities) {
            return null;
        }

        $dataRentalSpaceEav = [];
        foreach ($entities as $entity) {
            if ($entity['attribute'] === 'generalSpaceInformationTermsOfService')
            {
                $dataRentalSpaceEav[$entity['attribute']] = $entity['value'];
            }
            if ($entity['type_step'] === 'booking_system')
            {
                $dataRentalSpaceEav[$entity['attribute']] = $entity['value'];
            }
        }

        $resultBookingSystem = new RentalSpaceBookingSystem(
            $rentalSpaceId,
            RentalSpaceAgreeingToTermsValue::fromValue($dataRentalSpaceEav['bookingSystem__agreeingToTerms'])
        );
        [$resultBookingSystem, $termsOfUse] = [$resultBookingSystem, $dataRentalSpaceEav['generalSpaceInformationTermsOfService']];
        return [$resultBookingSystem, $termsOfUse];
    }

    /**
     * Create Booking System Advanced
     * @param RentalSpaceBookingSystemAdvanced $bookingSystemAdvanced
     * @return RentalSpaceId
     * @throws InvalidArgumentException
     */
    public function createRentalSpaceBookingSystemAdvanced(RentalSpaceBookingSystemAdvanced $bookingSystemAdvanced): RentalSpaceId
    {
        $rentalSpace = ModelRentalSpace::find($bookingSystemAdvanced->getRentalSpaceId()->getValue());
        $rentalSpace->update([
            'bookingInformation__lastMinuteBookDiscountEnabled' =>$bookingSystemAdvanced->getEnableLastMinuteDiscount(),
            'bookingInformation__lastMinuteBookDiscountDaysBeforeCount'=>$bookingSystemAdvanced->getLastMinuteBookDiscountDaysBeforeCount(),
            'bookingInformation__lastMinuteBookDiscountPercentage'=>$bookingSystemAdvanced->getLastMinuteBookDiscountPercentage()
        ]);

        return new RentalSpaceId($rentalSpace->id);
    }

    /**
     * Detail Booking system advanced
     *
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceBookingSystemAdvanced|null
     */
    public function findBookingSystemAdvancesBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalSpaceBookingSystemAdvanced
    {
        $rentalSpace = ModelRentalSpace::find($rentalSpaceId->getValue());
        if (!$rentalSpace) {
            return null;
        }

        return new RentalSpaceBookingSystemAdvanced(
            $rentalSpaceId,
            $rentalSpace->bookingInformation__lastMinuteBookDiscountEnabled,
            $rentalSpace->bookingInformation__lastMinuteBookDiscountDaysBeforeCount,
            $rentalSpace->bookingInformation__lastMinuteBookDiscountPercentage,
        );
    }
}
