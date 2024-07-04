<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRentalPlanRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetCurrentDraftStepApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceGeneralRepository
     */
    private IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository;

    /**
     * RentalSpaceRentalPlanRepository
     *
     * @var IRentalSpaceRentalPlanRepository
     */
    private IRentalSpaceRentalPlanRepository $rentalSpaceRentalPlanRepository;


    /**
     *
     */
    public function __construct(
        IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository,
        IRentalSpaceRentalPlanRepository $rentalSpaceRentalPlanRepository
    )
    {
        $this->rentalSpaceGeneralRepository = $rentalSpaceGeneralRepository;
        $this->rentalSpaceRentalPlanRepository = $rentalSpaceRentalPlanRepository;
    }

    /**
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetCurrentDraftStepCommand $command): RentalSpaceGetCurrentDraftStepResult
    {
        $rentalSpace = $this->rentalSpaceGeneralRepository->findCurrentDraftStepBySpaceId(new RentalSpaceId($command->rentalSpaceId));

        if (!$rentalSpace) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        $rentalPlanId = null;
        if ($rentalSpace->getDraftStep()->getCode() >= RentalSpaceDraftStep::fromType(RentalSpaceDraftStep::PLAN_CREATION)->getCode())
        {
            $rentalPlan = $this->rentalSpaceRentalPlanRepository->firstPlanBySpaceId(new RentalSpaceId($command->rentalSpaceId));
            if (!empty($rentalPlan)) {
                $rentalPlanId = $rentalPlan->getValue();
            }
        
        }

        return new RentalSpaceGetCurrentDraftStepResult(
            $rentalSpace->getRentalSpaceId()->getValue(),
            RentalSpaceDraftStep::fromValue($rentalSpace->getDraftStep()->getValue())->getValue(),
            $rentalSpace->getRentalSpaceApproval()->getStatus() === 'published',
            $rentalPlanId
        );
    }
}
