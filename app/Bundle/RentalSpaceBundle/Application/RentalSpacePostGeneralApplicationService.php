<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGeneral;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGeneralCancellationFeeRule;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGeneralPurposeOfUse;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpacePostGeneralApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceGeneralRepository
     */
    private IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository;


    /**
     *
     */
    public function __construct(
        IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository
    ) {
        $this->rentalSpaceGeneralRepository = $rentalSpaceGeneralRepository;
    }

    /**
     * @param RentalSpacePostGeneralCommand $command command
     * @return RentalSpacePostGeneralResult
     * @throws TransactionException|InvalidArgumentException
     */
    public function handle(RentalSpacePostGeneralCommand $command): RentalSpacePostGeneralResult
    {
        $rentalSpaceGeneralPurposeOfUses = [];
        if (!empty($command->generalBasicSpacePurposeOfUses)) {
            foreach ($command->generalBasicSpacePurposeOfUses as $generalBasicSpacePurposeOfUseCommand) {
                $rentalSpaceGeneralPurposeOfUses[] = new RentalSpaceGeneralPurposeOfUse(
                    $generalBasicSpacePurposeOfUseCommand->mainCategory,
                    $generalBasicSpacePurposeOfUseCommand->subCategory,
                    $generalBasicSpacePurposeOfUseCommand->titleCategory,
                );
            }
        }

        $rentalSpaceGeneralCancellationFeeRules = [];
        if (!empty($command->generalSpaceInformationCancellationFeeRules)) {
            foreach ($command->generalSpaceInformationCancellationFeeRules as $generalSpaceInformationCancellationFeeRuleCommand) {
                $rentalSpaceGeneralCancellationFeeRules[] = new RentalSpaceGeneralCancellationFeeRule(
                    $generalSpaceInformationCancellationFeeRuleCommand->startDay,
                    $generalSpaceInformationCancellationFeeRuleCommand->endDay,
                    $generalSpaceInformationCancellationFeeRuleCommand->percentage,
                    $generalSpaceInformationCancellationFeeRuleCommand->isCouponApplicable,
                );
            }
        }

        $rentalSpaceGeneral = new RentalSpaceGeneral(
            $command->organizationId,
            $command->generalBasicSpaceNameJa,
            $command->generalBasicSpaceNameKana,
            $command->generalBasicSpaceOverview,
            $command->generalBasicSpaceIntroduction,
            $rentalSpaceGeneralPurposeOfUses,
            $command->generalLocationPostCode,
            $command->generalLocationPrefecture,
            $command->generalLocationMunicipality,
            $command->generalLocationAddressJa,
            $command->generalLocationAccessInstructionJa,
            $command->generalLocationLatitude,
            $command->generalLocationLongitude,
            $command->generalSpaceInformationMinimumCapacity,
            $command->generalSpaceInformationMaximumCapacity,
            $command->generalSpaceInformationSpaciousnessDescriptionJa,
            $command->generalSpaceInformationPlanJa,
            $command->generalSpaceInformationMovie,
            $command->generalSpaceInformationMinimumDurationMinutes,
            $command->generalSpaceInformationMaximumBudget,
            $command->generalSpaceInformationCheapestPriceGuarantee,
            $command->generalSpaceInformationTermsOfService,
            $command->generalSpaceInformationCancellationPolicy,
            $rentalSpaceGeneralCancellationFeeRules,
            $command->generalContactOperatingCompanyJa,
            $command->generalContactPersonInChargeJa,
            $command->generalContactPhoneNumberJa,
            $command->generalContactEmail
        );

        $rentalSpace = new RentalSpace(
            null,
            RentalSpaceDraftStep::fromType(RentalSpaceDraftStep::GENERAL),
            $rentalSpaceGeneral,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        DB::beginTransaction();
        try {
            $rentalSpaceResponse = $this->rentalSpaceGeneralRepository->createRentalSpaceGeneral($rentalSpace);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
        [$id, $draftStep] = $rentalSpaceResponse;
        return new RentalSpacePostGeneralResult(
            $id->getValue(),
            $draftStep->getValue()
        );
    }
}
