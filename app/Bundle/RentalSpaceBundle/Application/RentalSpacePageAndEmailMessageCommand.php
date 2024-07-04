<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePageAndEmailMessageCommand
{
    public ?string $tomorrowsReminder;
    public ?string $reservationAfterPayment;
    public ?string $reservationCreation;
    public ?string $questionsFromSpace;
    public ?string $noteFromSpace;
    public ?string $notices;
    public ?string $faq;
    public ?string $prohibitedMatter;
    public int $rentalSpaceId;
    public string $termOfUse;
    public string $cancellationPolicy;
    public string $tourComplete;

    /**
     * @param int $rentalSpaceId
     * @param string $termOfUse
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
        int $rentalSpaceId,
        string $termOfUse,
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
        $this->termOfUse = $termOfUse;
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
}
