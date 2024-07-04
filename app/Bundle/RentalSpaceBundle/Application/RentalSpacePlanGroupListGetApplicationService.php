<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpacePlanGroupListGetApplicationService
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
     * @throws TransactionException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpacePlanGroupListGetCommand $command): ?RentalSpacePlanGroupListGetResult
    {
        $rentalPlanGroups = $this->rentalPlanRepository->findAllPlanGroup(new RentalSpaceId($command->rentalSpaceId));

        $responsePlanGroups = [];
        foreach ($rentalPlanGroups as $rentalPlanGroup) {
            $rentalPlans = [];
            foreach ($rentalPlanGroup->getRentalPlans() as $planId) {
                $findRentalPlans = $this->rentalPlanRepository->findById(new RentalSpaceId($command->rentalSpaceId), $planId);

                $rentalPlans[] = new RentalSpacePlanGroupRentalPlanResult(
                    $planId->getValue(),
                    $findRentalPlans[0]->getPlanName()
                );
            }

            $responsePlanGroups[] = new RentalSpacePlanGroupResult(
                $rentalPlanGroup->getPlanGroupId()->getValue(),
                $rentalPlanGroup->getPlanGroupName(),
                $rentalPlanGroup->getStatus()->getValue(),
                $rentalPlans
            );
        }
        return new RentalSpacePlanGroupListGetResult(
            $responsePlanGroups
        );
    }
}
