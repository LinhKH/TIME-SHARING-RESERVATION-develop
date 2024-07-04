<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalPlanGroupId;

final class RentalSpaceRentalPlanGroupDetailGetApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceRentalPlanRepository
     */
    private IRentalSpaceRentalPlanRepository $rentalPlanRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceRentalPlanRepository $rentalPlanRepository
    )
    {
        $this->rentalPlanRepository = $rentalPlanRepository;
    }


    /**
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceRentalPlanGroupDetailGetCommand $command): ?RentalSpaceRentalPlanGroupDetailGetResult
    {
        $rentalPlanGroups = $this->rentalPlanRepository->findPlanGroupById(new RentalPlanGroupId($command->rentalPlanGroupId));
        if (!$rentalPlanGroups) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $rentalPlans = [];
        foreach ($rentalPlanGroups->getRentalPlans() as $rentalPlanId) {
            $findRentalPlans = $this->rentalPlanRepository->findById($rentalPlanGroups->getRentalSpaceId(), $rentalPlanId);
            $rentalPlans[] = new RentalSpacePlanGroupRentalPlanResult(
                $rentalPlanId->getValue(),
                $findRentalPlans[0]->getPlanName()
            );
        }

        return new RentalSpaceRentalPlanGroupDetailGetResult(
            new RentalSpacePlanGroupResult(
              $rentalPlanGroups->getPlanGroupId()->getValue(),
              $rentalPlanGroups->getPlanGroupName(),
              $rentalPlanGroups->getStatus()->getValue(),
              $rentalPlans
            ),
        );
    }
}
