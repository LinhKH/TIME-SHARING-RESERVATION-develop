<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpacePageAndEmailMessage
{
    private ?string $tomorrowsReminder;
    private ?string $reservationAfterPayment;
    private ?string $reservationCreation;
    private ?string $questionsFromSpace;
    private ?string $noteFromSpace;
    private ?string $notices;
    private ?string $faq;
    private ?string $prohibitedMatter;
    private RentalSpaceId $rentalSpaceId;
    private string $termsOfUse;
    private string $cancellationPolicy;
    private ?string $tourComplete;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param string $termsOfUse
     * @param string $cancellationPolicy
     * @param string|null $prohibitedMatter
     * @param string|null $faq
     * @param string|null $notices
     * @param string|null $noteFromSpace
     * @param string|null $questionsFromSpace
     * @param string|null $reservationCreation
     * @param string|null $reservationAfterPayment
     * @param string|null $tomorrowsReminder
     * @param string|null $tourComplete
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        string $termsOfUse,
        string $cancellationPolicy,
        ?string $prohibitedMatter,
        ?string $faq,
        ?string $notices,
        ?string $noteFromSpace,
        ?string $questionsFromSpace,
        ?string $reservationCreation,
        ?string $reservationAfterPayment,
        ?string $tomorrowsReminder,
        ?string $tourComplete
    ){
        $this->cancellationPolicy = $cancellationPolicy;
        $this->termsOfUse = $termsOfUse;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->prohibitedMatter = $prohibitedMatter;
        $this->faq = $faq;
        $this->notices = $notices;
        $this->noteFromSpace = $noteFromSpace;
        $this->questionsFromSpace = $questionsFromSpace;
        $this->reservationCreation = $reservationCreation;
        $this->reservationAfterPayment = $reservationAfterPayment;
        $this->tomorrowsReminder = $tomorrowsReminder;
        $this->tourComplete = $tourComplete;
    }

    /**
     * @return string|null
     */
    public function getTomorrowsReminder(): ?string
    {
        return $this->tomorrowsReminder;
    }

    /**
     * @return string|null
     */
    public function getReservationAfterPayment(): ?string
    {
        return $this->reservationAfterPayment;
    }

    /**
     * @return string|null
     */
    public function getReservationCreation(): ?string
    {
        return $this->reservationCreation;
    }

    /**
     * @return string|null
     */
    public function getQuestionsFromSpace(): ?string
    {
        return $this->questionsFromSpace;
    }

    /**
     * @return string|null
     */
    public function getNoteFromSpace(): ?string
    {
        return $this->noteFromSpace;
    }

    /**
     * @return string|null
     */
    public function getNotices(): ?string
    {
        return $this->notices;
    }

    /**
     * @return string|null
     */
    public function getFaq(): ?string
    {
        return $this->faq;
    }

    /**
     * @return string|null
     */
    public function getProhibitedMatter(): ?string
    {
        return $this->prohibitedMatter;
    }

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return string
     */
    public function getTermsOfUse(): string
    {
        return $this->termsOfUse;
    }

    /**
     * @return string
     */
    public function getCancellationPolicy(): string
    {
        return $this->cancellationPolicy;
    }

    /**
     * @return string|null
     */
    public function getTourComplete(): ?string
    {
        return $this->tourComplete;
    }
}
