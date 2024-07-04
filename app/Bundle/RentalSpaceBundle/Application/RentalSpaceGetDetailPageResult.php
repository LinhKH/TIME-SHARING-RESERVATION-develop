<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailPageResult
{
    public ?string $questionsFromSpace;
    public ?string $noteFromSpace;
    public ?string $notices;
    public ?string $faq;
    public ?string $prohibitedMatter;
    public RentalSpaceId $rentalSpaceId;
    public string $termOfUse;
    public string $cancellationPolicy;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param string|null $prohibitedMatter
     * @param string|null $faq
     * @param string|null $notices
     * @param string|null $noteFromSpace
     * @param string|null $questionsFromSpace
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        string $termOfUse,
        string $cancellationPolicy,
        ?string $prohibitedMatter,
        ?string $faq,
        ?string $notices,
        ?string $noteFromSpace,
        ?string $questionsFromSpace

    ){
        $this->cancellationPolicy = $cancellationPolicy;
        $this->termOfUse = $termOfUse;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->prohibitedMatter = $prohibitedMatter;
        $this->faq = $faq;
        $this->notices = $notices;
        $this->noteFromSpace = $noteFromSpace;
        $this->questionsFromSpace = $questionsFromSpace;
    }
}
