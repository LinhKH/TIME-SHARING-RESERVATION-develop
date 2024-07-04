<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePutGeneralCommand
{
    public int $organizationId;
    public string $generalBasicSpaceNameJa;
    public ?string $generalBasicSpaceNameKana;
    public ?string $generalBasicSpaceOverview;
    public string $generalBasicSpaceIntroduction;
    public array  $generalBasicSpacePurposeOfUses;
    public string $generalLocationPostCode;
    public string $generalLocationPrefecture;
    public string $generalLocationMunicipality;
    public string $generalLocationAddressJa;
    public string $generalLocationAccessInstructionJa;
    public ?float $generalLocationLatitude;
    public ?float $generalLocationLongitude;
    public int $generalSpaceInformationMinimumCapacity;
    public int $generalSpaceInformationMaximumCapacity;
    public string $generalSpaceInformationSpaciousnessDescriptionJa;
    public string $generalSpaceInformationPlanJa;
    public ?string $generalSpaceInformationMovie;
    public ?string $generalSpaceInformationMinimumDurationMinutes;
    public ?float $generalSpaceInformationMaximumBudget;
    public ?bool $generalSpaceInformationCheapestPriceGuarantee;
    public string $generalSpaceInformationTermsOfService;
    public string $generalSpaceInformationCancellationPolicy;
    public ?array $generalSpaceInformationCancellationFeeRules;
    public ?string $generalContactOperatingCompanyJa;
    public ?string $generalContactPersonInChargeJa;
    public string $generalContactPhoneNumberJa;
    public string $generalContactEmail;
    public int $rentalSpaceId;

    /**
     * @param int $rentalSpaceId
     * @param int $organizationId
     * @param string $generalBasicSpaceNameJa
     * @param string|null $generalBasicSpaceNameKana
     * @param string|null $generalBasicSpaceOverview
     * @param string $generalBasicSpaceIntroduction
     * @param array $generalBasicSpacePurposeOfUses
     * @param string $generalLocationPostCode
     * @param string $generalLocationPrefecture
     * @param string $generalLocationMunicipality
     * @param string $generalLocationAddressJa
     * @param string $generalLocationAccessInstructionJa
     * @param float|null $generalLocationLatitude
     * @param float|null $generalLocationLongitude
     * @param int $generalSpaceInformationMinimumCapacity
     * @param int $generalSpaceInformationMaximumCapacity
     * @param string $generalSpaceInformationSpaciousnessDescriptionJa
     * @param string $generalSpaceInformationPlanJa
     * @param string|null $generalSpaceInformationMovie
     * @param string|null $generalSpaceInformationMinimumDurationMinutes
     * @param float|null $generalSpaceInformationMaximumBudget
     * @param bool|null $generalSpaceInformationCheapestPriceGuarantee
     * @param string $generalSpaceInformationTermsOfService
     * @param string $generalSpaceInformationCancellationPolicy
     * @param RentalSpaceGeneralCancellationFeeRuleCommand|null $generalSpaceInformationCancellationFeeRules
     * @param string|null $generalContactOperatingCompanyJa
     * @param string|null $generalContactPersonInChargeJa
     * @param string $generalContactPhoneNumberJa
     * @param string $generalContactEmail
     */
    public function __construct(
        int $rentalSpaceId,
        int $organizationId,
        string $generalBasicSpaceNameJa,
        ?string $generalBasicSpaceNameKana,
        ?string $generalBasicSpaceOverview,
        string $generalBasicSpaceIntroduction,
        array $generalBasicSpacePurposeOfUses,
        string $generalLocationPostCode,
        string $generalLocationPrefecture,
        string $generalLocationMunicipality,
        string $generalLocationAddressJa,
        string $generalLocationAccessInstructionJa,
        ?float $generalLocationLatitude,
        ?float $generalLocationLongitude,
        int $generalSpaceInformationMinimumCapacity,
        int $generalSpaceInformationMaximumCapacity,
        string $generalSpaceInformationSpaciousnessDescriptionJa,
        string $generalSpaceInformationPlanJa,
        ?string $generalSpaceInformationMovie,
        ?string $generalSpaceInformationMinimumDurationMinutes,
        ?float $generalSpaceInformationMaximumBudget,
        ?bool $generalSpaceInformationCheapestPriceGuarantee,
        string $generalSpaceInformationTermsOfService,
        string $generalSpaceInformationCancellationPolicy,
        ?array $generalSpaceInformationCancellationFeeRules,
        ?string $generalContactOperatingCompanyJa,
        ?string $generalContactPersonInChargeJa,
        string $generalContactPhoneNumberJa,
        string $generalContactEmail
    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
        $this->organizationId = $organizationId;
        $this->generalBasicSpaceNameJa = $generalBasicSpaceNameJa;
        $this->generalBasicSpaceNameKana = $generalBasicSpaceNameKana;
        $this->generalBasicSpaceOverview = $generalBasicSpaceOverview;
        $this->generalBasicSpaceIntroduction = $generalBasicSpaceIntroduction;
        $this->generalBasicSpacePurposeOfUses = $generalBasicSpacePurposeOfUses;
        $this->generalLocationPostCode = $generalLocationPostCode;
        $this->generalLocationPrefecture = $generalLocationPrefecture;
        $this->generalLocationMunicipality = $generalLocationMunicipality;
        $this->generalLocationAddressJa = $generalLocationAddressJa;
        $this->generalLocationAccessInstructionJa = $generalLocationAccessInstructionJa;
        $this->generalLocationLatitude = $generalLocationLatitude;
        $this->generalLocationLongitude = $generalLocationLongitude;
        $this->generalSpaceInformationMinimumCapacity = $generalSpaceInformationMinimumCapacity;
        $this->generalSpaceInformationMaximumCapacity = $generalSpaceInformationMaximumCapacity;
        $this->generalSpaceInformationSpaciousnessDescriptionJa = $generalSpaceInformationSpaciousnessDescriptionJa;
        $this->generalSpaceInformationPlanJa = $generalSpaceInformationPlanJa;
        $this->generalSpaceInformationMovie = $generalSpaceInformationMovie;
        $this->generalSpaceInformationMinimumDurationMinutes = $generalSpaceInformationMinimumDurationMinutes;
        $this->generalSpaceInformationMaximumBudget = $generalSpaceInformationMaximumBudget;
        $this->generalSpaceInformationCheapestPriceGuarantee = $generalSpaceInformationCheapestPriceGuarantee;
        $this->generalSpaceInformationTermsOfService = $generalSpaceInformationTermsOfService;
        $this->generalSpaceInformationCancellationPolicy = $generalSpaceInformationCancellationPolicy;
        $this->generalSpaceInformationCancellationFeeRules = $generalSpaceInformationCancellationFeeRules;
        $this->generalContactOperatingCompanyJa = $generalContactOperatingCompanyJa;
        $this->generalContactPersonInChargeJa = $generalContactPersonInChargeJa;
        $this->generalContactPhoneNumberJa = $generalContactPhoneNumberJa;
        $this->generalContactEmail = $generalContactEmail;
    }
}
