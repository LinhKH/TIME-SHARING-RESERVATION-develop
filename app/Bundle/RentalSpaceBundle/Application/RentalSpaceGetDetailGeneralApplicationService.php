<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGeneralCancellationFeeRule;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGeneralPurposeOfUse;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailGeneralApplicationService
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
    )
    {
        $this->rentalSpaceGeneralRepository = $rentalSpaceGeneralRepository;
    }

    /**
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailGeneralCommand $command): RentalSpaceGetDetailGeneralResult
    {
        $generals = $this->rentalSpaceGeneralRepository->findById(new RentalSpaceId($command->rentalSpaceId));

        if (!$generals) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        $generalBasicSpacePurposeOfUses = [];
        foreach ($generals->getGeneralBasicSpacePurposeOfUses() as $spacePurposeOfUse) {
            $generalBasicSpacePurposeOfUses[] = $spacePurposeOfUse;
        }

        $generalSpaceInformationCancellationFeeRules = [];
        foreach ($generals->getGeneralSpaceInformationCancellationFeeRules() as $cancellationFeeRule) {
            $generalSpaceInformationCancellationFeeRules[] = $cancellationFeeRule;
        }

        return new RentalSpaceGetDetailGeneralResult(
            $generals->getOrganizationId(),
            $generals->getGeneralBasicSpaceNameJa(),
            $generals->getGeneralBasicSpaceNameKana(),
            $generals->getGeneralBasicSpaceOverview(),
            $generals->getGeneralBasicSpaceIntroduction(),
            $generalBasicSpacePurposeOfUses,
            $generals->getGeneralLocationPostCode(),
            $generals->getGeneralLocationPrefecture(),
            $generals->getGeneralLocationMunicipality(),
            $generals->getGeneralLocationAddressJa(),
            $generals->getGeneralLocationAccessInstructionJa(),
            $generals->getGeneralLocationLatitude(),
            $generals->getGeneralLocationLongitude(),
            $generals->getGeneralSpaceInformationMinimumCapacity(),
            $generals->getGeneralSpaceInformationMaximumCapacity(),
            $generals->getGeneralSpaceInformationSpaciousnessDescriptionJa(),
            $generals->getGeneralSpaceInformationPlanJa(),
            $generals->getGeneralSpaceInformationMovie(),
            $generals->getGeneralSpaceInformationMinimumDurationMinutes(),
            $generals->getGeneralSpaceInformationMaximumBudget(),
            $generals->getGeneralSpaceInformationCheapestPriceGuarantee(),
            $generals->getGeneralSpaceInformationTermsOfService(),
            $generals->getGeneralSpaceInformationCancellationPolicy(),
            $generalSpaceInformationCancellationFeeRules,
            $generals->getGeneralContactOperatingCompanyJa(),
            $generals->getGeneralContactPersonInChargeJa(),
            $generals->getGeneralContactPhoneNumberJa(),
            $generals->getGeneralContactEmail()
        );
    }
}
