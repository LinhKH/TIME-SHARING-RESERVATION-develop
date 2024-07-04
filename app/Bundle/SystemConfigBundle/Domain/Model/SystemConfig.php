<?php
namespace App\Bundle\SystemConfigBundle\Domain\Model;

final class SystemConfig {

    private ?SystemConfigId $systemConfigId;
    private ReservationConfiguration $reservationConfiguration;
    private ConciergeWorkingTimesConfiguration $conciergeWorkingTimesConfiguration;
    private TemporaryReservation $temporaryReservation;
    private ?int $inquiryReminderForNotRespondYetHours;
    private ?int $tourRequestDenialPeriod;
    private ?string $frontendTrackingCodeHtml;
    private ?string $backendTrackingCodeHtml;

    /**
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\SystemConfigId|null $systemConfigId systemConfigId
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\ReservationConfiguration $reservationConfiguration reservationConfiguration
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\ConciergeWorkingTimesConfiguration $conciergeWorkingTimesConfiguration conciergeWorkingTimesConfiguration
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\TemporaryReservation $temporaryReservation temporaryReservation
     * @param int $inquiryReminderForNotRespondYetHours inquiryReminderForNotRespondYetHours
     * @param int $tourRequestDenialPeriod tourRequestDenialPeriod
     * @param string|null $frontendTrackingCodeHtml frontendTrackingCodeHtml
     * @param string|null $backendTrackingCodeHtml backendTrackingCodeHtml
     */
    public function __construct(
        ?SystemConfigId $systemConfigId,
        ReservationConfiguration $reservationConfiguration,
        ConciergeWorkingTimesConfiguration $conciergeWorkingTimesConfiguration,
        TemporaryReservation $temporaryReservation,
        ?int $inquiryReminderForNotRespondYetHours,
        ?int $tourRequestDenialPeriod,
        ?string $frontendTrackingCodeHtml,
        ?string $backendTrackingCodeHtml
    ) {
        $this->systemConfigId = $systemConfigId;
        $this->reservationConfiguration = $reservationConfiguration;
        $this->conciergeWorkingTimesConfiguration = $conciergeWorkingTimesConfiguration;
        $this->temporaryReservation = $temporaryReservation;
        $this->inquiryReminderForNotRespondYetHours = $inquiryReminderForNotRespondYetHours;
        $this->tourRequestDenialPeriod = $tourRequestDenialPeriod;
        $this->frontendTrackingCodeHtml = $frontendTrackingCodeHtml;
        $this->backendTrackingCodeHtml = $backendTrackingCodeHtml;
    }

    /**
     * @return \App\Bundle\SystemConfigBundle\Domain\Model\SystemConfigId|null
     */
    public function getSystemConfigId(): ?SystemConfigId
    {
        return $this->systemConfigId;
    }

    /**
     * @return \App\Bundle\SystemConfigBundle\Domain\Model\ReservationConfiguration
     */
    public function getReservationConfiguration(): ReservationConfiguration
    {
        return $this->reservationConfiguration;
    }

    /**
     * @return \App\Bundle\SystemConfigBundle\Domain\Model\ConciergeWorkingTimesConfiguration
     */
    public function getConciergeWorkingTimesConfiguration(): ConciergeWorkingTimesConfiguration
    {
        return $this->conciergeWorkingTimesConfiguration;
    }

    /**
     * @return \App\Bundle\SystemConfigBundle\Domain\Model\TemporaryReservation
     */
    public function getTemporaryReservation(): TemporaryReservation
    {
        return $this->temporaryReservation;
    }

    /**
     * @return int
     */
    public function getInquiryReminderForNotRespondYetHours(): ?int
    {
        return $this->inquiryReminderForNotRespondYetHours;
    }

    /**
     * @return int
     */
    public function getTourRequestDenialPeriod(): ?int
    {
        return $this->tourRequestDenialPeriod;
    }

    /**
     * @return string|null
     */
    public function getFrontendTrackingCodeHtml(): ?string
    {
        return $this->frontendTrackingCodeHtml;
    }

    /**
     * @return string|null
     */
    public function getBackendTrackingCodeHtml(): ?string
    {
        return $this->backendTrackingCodeHtml;
    }
}
