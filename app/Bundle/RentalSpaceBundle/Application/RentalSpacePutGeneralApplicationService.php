<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGeneral;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGeneralCancellationFeeRule;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGeneralPurposeOfUse;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Models\RentalSpacePage;
use App\Models\RentalSpacePageEav;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpacePutGeneralApplicationService
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
     * @param RentalSpacePutGeneralCommand $command
     * @return RentalSpacePutGeneralResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    public function handle(RentalSpacePutGeneralCommand $command): RentalSpacePutGeneralResult
    {
        $rentalSpace = $this->rentalSpaceGeneralRepository->checkExistSpace(new RentalSpaceId($command->rentalSpaceId));
        if (!$rentalSpace) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
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
            new RentalSpaceId($command->rentalSpaceId),
            null,
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
            $rentalSpaceId = $this->rentalSpaceGeneralRepository->updateRentalSpaceGeneral($rentalSpace);

            $rentalSpace = RentalSpacePage::where('rental_space_id', $command->rentalSpaceId)->where('type', 'term_of_use')->first();
            if (!empty($rentalSpace)) {
                $rentalSpaceEav = RentalSpacePageEav::where('namespace', $rentalSpace->id)->first();
                $rentalSpaceEav->update(['value' => $command->generalSpaceInformationTermsOfService]);
            }


            $rentalSpace = RentalSpacePage::where('rental_space_id', $command->rentalSpaceId)->where('type', 'cancellation_policy')->first();
            if (!empty($rentalSpace)) {
                $rentalSpaceEav = RentalSpacePageEav::where('namespace', $rentalSpace->id)->first();
                $rentalSpaceEav->update(['value' => $command->generalSpaceInformationCancellationPolicy]);
            }


            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new RentalSpacePutGeneralResult(
            $rentalSpaceId->getValue()
        );
    }
}
