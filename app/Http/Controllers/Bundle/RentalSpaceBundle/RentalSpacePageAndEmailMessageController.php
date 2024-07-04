<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceAllDetailEmailMessageGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceAllDetailEmailMessageGetCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetAllPageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetAllServiceApplication;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailEmailMessageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailEmailMessageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDetailPageAndEmailMessageGetApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDetailPageAndEmailMessageGetCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailPageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailPageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePageAndEmailMessageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePageAndEmailMessageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePutEmailMessageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePutEmailMessageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePutPageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePutPageCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpacePageAndEmailMessageRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentalSpaceGetDetailPageAndEmailMessageRequest;
use App\Http\Requests\RentalSpacePageAndEmailMessageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RentalSpacePageAndEmailMessageController extends Controller
{
    /**
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function postRentalSpacePageAndEmailMessage($rentalSpaceId, RentalSpacePageAndEmailMessageRequest $request): JsonResponse
    {
        $rentalSpacePageAndEmailMessageRepository = new RentalSpacePageAndEmailMessageRepository();
        $postRentalSpacePageAndEmailMessageApplicationService = new RentalSpacePageAndEmailMessageApplicationService(
            $rentalSpacePageAndEmailMessageRepository
        );

        $command = new RentalSpacePageAndEmailMessageCommand(
            $rentalSpaceId,
            $request->term_of_use,
            $request->cancellation_policy,
            $request->prohibited_matter ?? "",
            $request->faq ?? "",
            $request->notices ?? "",
            $request->note_from_space ?? "",
            $request->questions_from_space ?? "",
            $request->reservation_creation ?? "",
            $request->reservation_after_payment ?? "",
            $request->tomorrows_reminder ?? "",
            $request->tour_complete ?? ""
        );

        $rentalSpace = $postRentalSpacePageAndEmailMessageApplicationService->handle($command);
        $response = [
            'rental_space_id' => $rentalSpace->rentalSpaceId,
            'draft_step' => $rentalSpace->draftStep,
        ];
        return response()->json($response, 200);
    }

    /**
     * Get Detail Rental Space - Page
     */
    public function detailRentalSpacePage($rentalSpaceId): JsonResponse
    {
        $rentalSpacePageAndEmailMessageRepository = new RentalSpacePageAndEmailMessageRepository();
        $detailRentalSpacePageApplicationService = new RentalSpaceGetDetailPageApplicationService(
            $rentalSpacePageAndEmailMessageRepository
        );

        $command = new RentalSpaceGetDetailPageCommand($rentalSpaceId);
        $pages = $detailRentalSpacePageApplicationService->handle($command);

        $response = [
            "rental_space_id" => $pages->rentalSpaceId->getValue(),
            "term_of_use" => $pages->termOfUse,
            "cancellation_policy" => $pages->cancellationPolicy,
            "prohibited_matter" => $pages->prohibitedMatter,
            "faq" => $pages->faq,
            "notices" => $pages->notices,
            "note_from_space" => $pages->noteFromSpace,
            "questions_from_space" => $pages->questionsFromSpace
        ];
        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * Get Detail Rental Space - Email Message
     */
    public function detailRentalSpaceEmailMessage($rentalSpaceId): JsonResponse
    {
        $rentalSpacePageAndEmailMessageRepository = new RentalSpacePageAndEmailMessageRepository();
        $detailRentalSpaceEmailMessageApplicationService = new RentalSpaceGetDetailEmailMessageApplicationService(
            $rentalSpacePageAndEmailMessageRepository
        );

        $command = new RentalSpaceGetDetailEmailMessageCommand($rentalSpaceId);
        $emailMessages = $detailRentalSpaceEmailMessageApplicationService->handle($command);

        $response = [
            "rental_space_id" => $emailMessages->rentalSpaceId->getValue(),
            "reservation_creation" => $emailMessages->reservationCreation,
            "reservation_after_payment" => $emailMessages->reservationAfterPayment,
            "tomorrows_reminder" => $emailMessages->tomorrowsReminder,
            "tour_complete" => $emailMessages->tourComplete
        ];
        return response()->json(['status' => 200, 'data' => $response]);
    }

    /**
     * @param $rentalSpaceId
     * @return JsonResponse
     * @throws InvalidArgumentException
     */
    public function detailAllRentalSpaceEmailMessage($rentalSpaceId): JsonResponse
    {
        $rentalSpacePageAndMessageRepository = new RentalSpacePageAndEmailMessageRepository();
        $command = new RentalSpaceAllDetailEmailMessageGetCommand(
            $rentalSpaceId
        );
        $applicationService = new RentalSpaceAllDetailEmailMessageGetApplicationService($rentalSpacePageAndMessageRepository);
        $result = $applicationService->handle($command);

        return response()->json([
            'rental_space_id' => $result->rentalSpaceId,
            'email_message_result' => $result->emailMessageResult
        ], 200);

    }

    /**
     * @param $rentalSpaceId
     * @return JsonResponse
     * @throws InvalidArgumentException
     */
    public function getAllRentalSpacePage($rentalSpaceId): JsonResponse
    {
        $command = new RentalSpaceGetAllPageCommand(
            $rentalSpaceId
        );
        $rentalSpacePageAndEmailMessageRepository = new RentalSpacePageAndEmailMessageRepository();
        $application = new RentalSpaceGetAllServiceApplication($rentalSpacePageAndEmailMessageRepository);
        $result = $application->handle($command);
        return response()->json([
            'rental_space_id' => $result->rentalSpaceId,
            'pages' => $result->pageResult
        ], 200);
    }

    /**
     * @param $pageAndEmailId
     * @param RentalSpaceGetDetailPageAndEmailMessageRequest $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function getDetailPageAndEmailMessage($pageAndEmailId, RentalSpaceGetDetailPageAndEmailMessageRequest $request): JsonResponse
    {
        $command = new RentalSpaceDetailPageAndEmailMessageGetCommand(
            $pageAndEmailId,
            $request->type
        );
        $rentalSpacePageAndEmailMessageRepository = new RentalSpacePageAndEmailMessageRepository();
        $application = new RentalSpaceDetailPageAndEmailMessageGetApplicationService($rentalSpacePageAndEmailMessageRepository);
        $rentalSpaceGetDetailPageAndEmailMessageResult = $application->handle($command);
        return response()->json([
            'page_and_email_id' => $rentalSpaceGetDetailPageAndEmailMessageResult->pageAndEmailId,
            'title' => $rentalSpaceGetDetailPageAndEmailMessageResult->title,
            'content' => $rentalSpaceGetDetailPageAndEmailMessageResult->content,
            'type' => $rentalSpaceGetDetailPageAndEmailMessageResult->type
        ], 200);
    }

    /**
     * @param $pageId
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    public function updateRentalSpacePage($pageId, Request $request): JsonResponse
    {
        $command = new RentalSpacePutPageCommand(
            $pageId,
            $request->page_content,
            $request->title ?? null
        );

        $rentalSpacePageAndEmailMessageRepository = new RentalSpacePageAndEmailMessageRepository();
        $application = new RentalSpacePutPageApplicationService($rentalSpacePageAndEmailMessageRepository);
        $result = $application->handle($command);
        return response()->json([
            'page_id' => $result->getPageId()
        ], 200);
    }

    /**
     * @param $emailMessageId
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    public function updateRentalSpaceEmailMessage($emailMessageId, Request $request): JsonResponse
    {
        $command = new RentalSpacePutEmailMessageCommand(
            $emailMessageId,
            $request->email_content
        );
        $rentalSpacePageAndEmailMessageRepository = new RentalSpacePageAndEmailMessageRepository();
        $application = new RentalSpacePutEmailMessageApplicationService($rentalSpacePageAndEmailMessageRepository);
        $result = $application->handle($command);
        return response()->json([
            'email_message_id' => $result->emailMessageId
        ], 200);
    }
}
