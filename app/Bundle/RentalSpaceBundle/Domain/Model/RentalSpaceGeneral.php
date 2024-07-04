<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceGeneral
{
    private int $organizationId;
    private string $generalBasicSpaceNameJa;
    private ?string $generalBasicSpaceNameKana;
    private ?string $generalBasicSpaceOverview;
    private string $generalBasicSpaceIntroduction;
    private array $generalBasicSpacePurposeOfUses;
    private string $generalLocationPostCode;
    private string $generalLocationPrefecture;
    private string $generalLocationMunicipality;
    private string $generalLocationAddressJa;
    private string $generalLocationAccessInstructionJa;
    private ?float $generalLocationLatitude;
    private ?float $generalLocationLongitude;
    private int $generalSpaceInformationMinimumCapacity;
    private int $generalSpaceInformationMaximumCapacity;
    private string $generalSpaceInformationSpaciousnessDescriptionJa;
    private string $generalSpaceInformationPlanJa;
    private ?string $generalSpaceInformationMovie;
    private ?string $generalSpaceInformationMinimumDurationMinutes;
    private ?float $generalSpaceInformationMaximumBudget;
    private ?bool $generalSpaceInformationCheapestPriceGuarantee;
    private string $generalSpaceInformationTermsOfService;
    private string $generalSpaceInformationCancellationPolicy;
    private ?array $generalSpaceInformationCancellationFeeRules;
    private ?string $generalContactOperatingCompanyJa;
    private ?string $generalContactPersonInChargeJa;
    private string $generalContactPhoneNumberJa;
    private string $generalContactEmail;

    /**
     * @param int $organizationId
     * @param string $generalBasicSpaceNameJa
     * @param string|null $generalBasicSpaceNameKana
     * @param string|null $generalBasicSpaceOverview
     * @param string $generalBasicSpaceIntroduction
     * @param RentalSpaceGeneralPurposeOfUse[] $generalBasicSpacePurposeOfUses
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
     * @param RentalSpaceGeneralCancellationFeeRule[]|null $generalSpaceInformationCancellationFeeRules
     * @param string|null $generalContactOperatingCompanyJa
     * @param string|null $generalContactPersonInChargeJa
     * @param string $generalContactPhoneNumberJa
     * @param string $generalContactEmail
     */
    public function __construct(
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

    /**
     * @return int
     */
    public function getOrganizationId(): int
    {
        return $this->organizationId;
    }

    /**
     * @return string
     */
    public function getGeneralBasicSpaceNameJa(): string
    {
        return $this->generalBasicSpaceNameJa;
    }

    /**
     * @return string|null
     */
    public function getGeneralBasicSpaceNameKana(): ?string
    {
        return $this->generalBasicSpaceNameKana;
    }

    /**
     * @return string|null
     */
    public function getGeneralBasicSpaceOverview(): ?string
    {
        return $this->generalBasicSpaceOverview;
    }

    /**
     * @return string
     */
    public function getGeneralBasicSpaceIntroduction(): string
    {
        return $this->generalBasicSpaceIntroduction;
    }

    /**
     * @return string
     */
    public function getGeneralLocationPostCode(): string
    {
        return $this->generalLocationPostCode;
    }

    /**
     * @return string
     */
    public function getGeneralLocationPrefecture(): string
    {
        return $this->generalLocationPrefecture;
    }

    /**
     * @return string
     */
    public function getGeneralLocationMunicipality(): string
    {
        return $this->generalLocationMunicipality;
    }

    /**
     * @return string
     */
    public function getGeneralLocationAddressJa(): string
    {
        return $this->generalLocationAddressJa;
    }

    /**
     * @return string
     */
    public function getGeneralLocationAccessInstructionJa(): string
    {
        return $this->generalLocationAccessInstructionJa;
    }

    /**
     * @return float|null
     */
    public function getGeneralLocationLatitude(): ?float
    {
        return $this->generalLocationLatitude;
    }

    /**
     * @return float|null
     */
    public function getGeneralLocationLongitude(): ?float
    {
        return $this->generalLocationLongitude;
    }

    /**
     * @return int
     */
    public function getGeneralSpaceInformationMinimumCapacity(): int
    {
        return $this->generalSpaceInformationMinimumCapacity;
    }

    /**
     * @return int
     */
    public function getGeneralSpaceInformationMaximumCapacity(): int
    {
        return $this->generalSpaceInformationMaximumCapacity;
    }

    /**
     * @return string
     */
    public function getGeneralSpaceInformationSpaciousnessDescriptionJa(): string
    {
        return $this->generalSpaceInformationSpaciousnessDescriptionJa;
    }

    /**
     * @return string
     */
    public function getGeneralSpaceInformationPlanJa(): string
    {
        return $this->generalSpaceInformationPlanJa;
    }

    /**
     * @return string|null
     */
    public function getGeneralSpaceInformationMovie(): ?string
    {
        return $this->generalSpaceInformationMovie;
    }

    /**
     * @return string|null
     */
    public function getGeneralSpaceInformationMinimumDurationMinutes(): ?string
    {
        return $this->generalSpaceInformationMinimumDurationMinutes;
    }

    /**
     * @return float|null
     */
    public function getGeneralSpaceInformationMaximumBudget(): ?float
    {
        return $this->generalSpaceInformationMaximumBudget;
    }

    /**
     * @return bool|null
     */
    public function getGeneralSpaceInformationCheapestPriceGuarantee(): ?bool
    {
        return $this->generalSpaceInformationCheapestPriceGuarantee;
    }

    /**
     * @return string
     */
    public function getGeneralSpaceInformationTermsOfService(): string
    {
        return $this->generalSpaceInformationTermsOfService;
    }

    /**
     * @return string
     */
    public function getGeneralSpaceInformationCancellationPolicy(): string
    {
        return $this->generalSpaceInformationCancellationPolicy;
    }

    /**
     * @return string|null
     */
    public function getGeneralContactOperatingCompanyJa(): ?string
    {
        return $this->generalContactOperatingCompanyJa;
    }

    /**
     * @return RentalSpaceGeneralPurposeOfUse[]
     */
    public function getGeneralBasicSpacePurposeOfUses(): array
    {
        return $this->generalBasicSpacePurposeOfUses;
    }

    /**
     * @return RentalSpaceGeneralCancellationFeeRule[]|null
     */
    public function getGeneralSpaceInformationCancellationFeeRules(): ?array
    {
        return $this->generalSpaceInformationCancellationFeeRules;
    }

    /**
     * @return string|null
     */
    public function getGeneralContactPersonInChargeJa(): ?string
    {
        return $this->generalContactPersonInChargeJa;
    }

    /**
     * @return int
     */
    public function getGeneralContactPhoneNumberJa(): string
    {
        return $this->generalContactPhoneNumberJa;
    }

    /**
     * @return string
     */
    public function getGeneralContactEmail(): string
    {
        return $this->generalContactEmail;
    }


}
