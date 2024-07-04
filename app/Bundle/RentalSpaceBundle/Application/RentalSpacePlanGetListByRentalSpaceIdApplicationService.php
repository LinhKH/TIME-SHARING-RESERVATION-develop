<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpacePlanGetListByRentalSpaceIdApplicationService
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
     * @param RentalSpacePlanGetListByRentalSpaceIdCommand $command
     * @return RentalSpacePlanGetListByRentalSpaceIdResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpacePlanGetListByRentalSpaceIdCommand $command): RentalSpacePlanGetListByRentalSpaceIdResult
    {
        $rentalPlans = $this->rentalPlanRepository->findBySpaceId(new RentalSpaceId($command->rentalSpaceId));

        if (empty($rentalPlans)) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        return new RentalSpacePlanGetListByRentalSpaceIdResult(
            $rentalPlans
        );
    }
}
