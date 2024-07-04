<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpacePageAndEmailMessageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\PageAndEmailId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGetPageAndEmailMessageAllInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpacePageAndEmailMessage;
use App\Models\RentalSpace as RentalSpaceModel;
use App\Models\RentalSpaceEmailMessage as RentalSpaceEmailMessageModel;
use App\Models\RentalSpaceEmailMessageEav as RentalSpaceEmailMessageEavModel;
use App\Models\RentalSpacePage as RentalSpacePageModel;
use App\Models\RentalSpacePageEav as RentalSpacePageEavModel;

class RentalSpacePageAndEmailMessageRepository implements IRentalSpacePageAndEmailMessageRepository
{

    /**
     * @throws InvalidArgumentException
     */
    public function createRentalSpacePageAndEmailMessage(RentalSpace $rentalSpace): array
    {
        // TODO: Implement createRentalSpacePageAndEmailMessage() method.

        $rentalSpacePages = [
            "term_of_use" => $rentalSpace->getRentalSpacePageAndEmailMessage()->getTermsOfUse(),
            "cancellation_policy" => $rentalSpace->getRentalSpacePageAndEmailMessage()->getCancellationPolicy(),
            "prohibited_matter" => $rentalSpace->getRentalSpacePageAndEmailMessage()->getProhibitedMatter(),
            "faq" => $rentalSpace->getRentalSpacePageAndEmailMessage()->getFaq(),
            "notices" => $rentalSpace->getRentalSpacePageAndEmailMessage()->getNotices(),
            "note_from_space" => $rentalSpace->getRentalSpacePageAndEmailMessage()->getNoteFromSpace(),
            "questions_from_space" => $rentalSpace->getRentalSpacePageAndEmailMessage()->getQuestionsFromSpace()
        ];

        $rentalSpaceEmailMessages = [
            "reservation_creation" => $rentalSpace->getRentalSpacePageAndEmailMessage()->getReservationCreation(),
            "reservation_after_payment" => $rentalSpace->getRentalSpacePageAndEmailMessage()->getReservationAfterPayment(),
            "tomorrows_reminder" => $rentalSpace->getRentalSpacePageAndEmailMessage()->getTomorrowsReminder(),
            "tour_complete" => $rentalSpace->getRentalSpacePageAndEmailMessage()->getTourComplete()
        ];

        // Create Page
        foreach ($rentalSpacePages as $key => $value) {
            $rentalSpacePage = RentalSpacePageModel::create([
                'rental_space_id' => $rentalSpace->getRentalSpaceId()->getValue(),
                'type' => $key,
                'creation_time' => time()
            ]);
            RentalSpacePageEavModel::create([
                'namespace' => $rentalSpacePage->id,
                'attribute' => 'content__ja',
                'value' => $value,
                'type' => 's'
            ]);
        }

        //Create Email Message
        foreach ($rentalSpaceEmailMessages as $key => $value) {
            $rentalSpaceEmailMessage = RentalSpaceEmailMessageModel::create([
                'rental_space_id' => $rentalSpace->getRentalSpaceId()->getValue(),
                'type' => $key,
                'creation_time' => time()
            ]);
            RentalSpaceEmailMessageEavModel::create([
                'namespace' => $rentalSpaceEmailMessage->id,
                'attribute' => 'content__ja',
                'value' => $value,
                'type' => 's'
            ]);
        }


        $rentalSpaceModel = RentalSpaceModel::findOrFail($rentalSpace->getRentalSpaceId()->getValue());
        $rentalSpaceModel->update([
            'draft_step' => $rentalSpace->getDraftStep()->nextStep()
        ]);
        $rentalSpaceModel->save();
        return [new RentalSpaceId($rentalSpaceModel->id), new RentalSpaceDraftStep($rentalSpaceModel->draft_step)];
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpacePageAndEmailMessage|null
     */
    public function findPageBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalSpacePageAndEmailMessage
    {
        $entities = RentalSpacePageModel::where('rental_space_id', $rentalSpaceId->getValue())->with(['rentalSpacePageEav'])->get()->toArray();
        if (!$entities) {
            return null;
        }
        $pages = [];
        foreach ($entities as $entity) {
            if (!empty($entity['rental_space_page_eav'])) {
                foreach ($entity['rental_space_page_eav'] as $item) {
                    $pages[$entity['type']] = $item['value'];
                }
            }
        }
        return new RentalSpacePageAndEmailMessage(
            $rentalSpaceId,
            $pages['term_of_use'],
            $pages['cancellation_policy'],
            $pages['prohibited_matter'] ?? null,
            $pages['faq'] ?? null,
            $pages['notices'] ?? null,
            $pages['note_from_space'] ?? null,
            $pages['questions_from_space'] ?? null,
            null,
            null,
            null,
            null
        );
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpacePageAndEmailMessage|null
     */
    public function findEmailMessageBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalSpacePageAndEmailMessage
    {
        $entities = RentalSpaceEmailMessageModel::where('rental_space_id', $rentalSpaceId->getValue())->with(['rentalSpaceEmailMessageEav'])->get()->toArray();
        if (!$entities) {
            return null;
        }
        $emailMessages = [];
        foreach ($entities as $entity) {
            if (!empty($entity['rental_space_email_message_eav'])) {
                foreach ($entity['rental_space_email_message_eav'] as $item) {
                    $emailMessages[$entity['type']] = $item['value'];
                }
            }
        }

        return new RentalSpacePageAndEmailMessage(
            $rentalSpaceId,
            '',
            '',
            null,
            null,
            null,
            null,
            null,
            $emailMessages['reservation_creation'] ?? null,
            $emailMessages['reservation_after_payment'] ?? null,
            $emailMessages['tomorrows_reminder'] ?? null,
            $emailMessages['tour_complete'] ?? null
        );
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceGetPageAndEmailMessageAllInformation[]|null
     * @throws InvalidArgumentException
     */
    public function findAllEmailMessageBySpaceId(RentalSpaceId $rentalSpaceId): ?array
    {
        $entityEmailMessage = RentalSpaceEmailMessageModel::where('rental_space_id', $rentalSpaceId->getValue())->with(['rentalSpaceEmailMessageEav'])->get()->toArray();
        $rentalSpaceMessage = null;
        if (!empty($entityEmailMessage)) {
            foreach ($entityEmailMessage as $entity) {
                if (!empty($entity['rental_space_email_message_eav'])) {
                    foreach ($entity['rental_space_email_message_eav'] as $item) {
                        $rentalSpaceMessage[] = new RentalSpaceGetPageAndEmailMessageAllInformation(
                            new PageAndEmailId($item['namespace']),
                            $entity['type'],
                            $item['value'],
                            null
                        );
                    }
                }
            }
        }

        return $rentalSpaceMessage;
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceGetPageAndEmailMessageAllInformation[]|null
     * @throws InvalidArgumentException
     */
    public function findAllPageMessageBySpaceId(RentalSpaceId $rentalSpaceId): ?array
    {
        $entityPages = RentalSpacePageModel::where('rental_space_id', $rentalSpaceId->getValue())->with(['rentalSpacePageEav'])->get()->toArray();
        $rentalSpacePages = null;
        if (!empty($entityPages)) {
            foreach ($entityPages as $entityPage) {
                if (!empty($entityPage['rental_space_page_eav'])) {
                    foreach ($entityPage['rental_space_page_eav'] as $item) {
                        $rentalSpacePages[] = new RentalSpaceGetPageAndEmailMessageAllInformation(
                            new PageAndEmailId($item['namespace']),
                            $entityPage['type'],
                            $item['value'],
                            null
                        );
                    }
                }
            }
        }
        return $rentalSpacePages;
    }

    /**
     * @param PageAndEmailId $pageAndEmailId
     * @return RentalSpaceGetPageAndEmailMessageAllInformation|null
     */
    public function findEmailMessageById(PageAndEmailId $pageAndEmailId): ?RentalSpaceGetPageAndEmailMessageAllInformation
    {
        $emailMessageEntity = RentalSpaceEmailMessageEavModel::where('namespace', $pageAndEmailId->getValue())->with('rentalSpaceEmailMessage')->orderBy('id', 'desc')->first();

        if (!$emailMessageEntity) {
            return null;
        }
        $emailMessageEntity = $emailMessageEntity->toArray();
        return new RentalSpaceGetPageAndEmailMessageAllInformation(
            $pageAndEmailId,
            $emailMessageEntity['rental_space_email_message']['type'],
            $emailMessageEntity['value'],
            null
        );
    }

    /**
     * @param PageAndEmailId $pageAndEmailId
     * @return RentalSpaceGetPageAndEmailMessageAllInformation|null
     */
    public function findPageById(PageAndEmailId $pageAndEmailId): ?RentalSpaceGetPageAndEmailMessageAllInformation
    {
        $pageEntity = RentalSpacePageEavModel::where('namespace', $pageAndEmailId->getValue())->with('rentalSpacePage')->orderBy('id', 'desc')->first();
        if (!$pageEntity) {
            return null;
        }
        $pageEntity = $pageEntity->toArray();
        return new RentalSpaceGetPageAndEmailMessageAllInformation(
            $pageAndEmailId,
            $pageEntity['rental_space_page']['type'],
            $pageEntity['value'],
            null
        );
    }

    /**
     * @param RentalSpaceGetPageAndEmailMessageAllInformation $rentalSpaceGetPageAndEmailMessageAllInformation
     * @return PageAndEmailId|null
     */
    public function updatePageById(RentalSpaceGetPageAndEmailMessageAllInformation $rentalSpaceGetPageAndEmailMessageAllInformation): ?PageAndEmailId
    {
        $pageEntity = RentalSpacePageModel::where('id', $rentalSpaceGetPageAndEmailMessageAllInformation->getId()->getValue())->with('rentalSpacePageEav')->first();
        if (!$pageEntity) {
            return null;
        }
        RentalSpacePageEavModel::where([
            'namespace' => $pageEntity->id,
            'attribute' => 'content__ja'
        ])->delete();
        RentalSpacePageEavModel::create([
            'namespace' => $pageEntity->id,
            'attribute' => 'content__ja',
            'value' => $rentalSpaceGetPageAndEmailMessageAllInformation->getContent(),
            'type' => 's',
        ]);
        return $rentalSpaceGetPageAndEmailMessageAllInformation->getId();
    }

    /**
     * @param RentalSpaceGetPageAndEmailMessageAllInformation $rentalSpaceGetPageAndEmailMessageAllInformation
     * @return PageAndEmailId|null
     */
    public function updateEmailMessageById(RentalSpaceGetPageAndEmailMessageAllInformation $rentalSpaceGetPageAndEmailMessageAllInformation): ?PageAndEmailId
    {
        $emailMessageEntity = RentalSpaceEmailMessageModel::where('id', $rentalSpaceGetPageAndEmailMessageAllInformation->getId()->getValue())->with('rentalSpaceEmailMessageEav')->first();
        if (!$emailMessageEntity) {
            return null;
        }
        RentalSpaceEmailMessageEavModel::where([
            'namespace' => $emailMessageEntity->id,
            'attribute' => 'content__ja'
        ])->delete();
        RentalSpaceEmailMessageEavModel::create([
            'namespace' => $emailMessageEntity->id,
            'attribute' => 'content__ja',
            'value' => $rentalSpaceGetPageAndEmailMessageAllInformation->getContent(),
            'type' => 's'
        ]);
        return $rentalSpaceGetPageAndEmailMessageAllInformation->getId();
    }
}
