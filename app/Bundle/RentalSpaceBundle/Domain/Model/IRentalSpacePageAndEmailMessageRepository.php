<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

interface IRentalSpacePageAndEmailMessageRepository
{
    /**
     * Create rental space general
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     */
    public function createRentalSpacePageAndEmailMessage(RentalSpace $rentalSpace): array;

    /**
     * Find rental space page by ID
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpacePageAndEmailMessage|null
     */
    public function findPageBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalSpacePageAndEmailMessage;

    /**
     * Find rental space message by ID
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpacePageAndEmailMessage|null
     */
    public function findEmailMessageBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalSpacePageAndEmailMessage;

    /**
     * Get all Email Message by Rental Space ID
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceGetPageAndEmailMessageAllInformation[]|null
     */
    public function findAllEmailMessageBySpaceId(RentalSpaceId $rentalSpaceId): ?array;

    /**
     * Get all Page by Rental Space ID
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceGetPageAndEmailMessageAllInformation[]|null
     */
    public function findAllPageMessageBySpaceId(RentalSpaceId $rentalSpaceId): ?array;

    /**
     * @param PageAndEmailId $pageAndEmailId
     * @return RentalSpaceGetPageAndEmailMessageAllInformation|null
     */
    public function findEmailMessageById(PageAndEmailId $pageAndEmailId): ?RentalSpaceGetPageAndEmailMessageAllInformation;

    /**
     * @param PageAndEmailId $pageAndEmailId
     * @return RentalSpaceGetPageAndEmailMessageAllInformation|null
     */
    public function findPageById(PageAndEmailId $pageAndEmailId): ?RentalSpaceGetPageAndEmailMessageAllInformation;

    /**
     * @param RentalSpaceGetPageAndEmailMessageAllInformation $rentalSpaceGetPageAndEmailMessageAllInformation
     * @return PageAndEmailId|null
     */
    public function updatePageById(RentalSpaceGetPageAndEmailMessageAllInformation $rentalSpaceGetPageAndEmailMessageAllInformation): ?PageAndEmailId;

    /**
     * @param RentalSpaceGetPageAndEmailMessageAllInformation $rentalSpaceGetPageAndEmailMessageAllInformation
     * @return PageAndEmailId|null
     */
    public function updateEmailMessageById(RentalSpaceGetPageAndEmailMessageAllInformation $rentalSpaceGetPageAndEmailMessageAllInformation): ?PageAndEmailId;
}
