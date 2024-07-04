<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailApprovalApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailApprovalCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePutApprovalApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePutApprovalCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceApprovalRepository;
use App\Bundle\SystemConfigBundle\Application\SystemConfigGetApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigGetCommand;
use App\Bundle\SystemConfigBundle\Infrastructure\SystemConfigRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentalSpaceApprovalRequest;
use Illuminate\Http\JsonResponse;
use App\Services\CommonConstant;
use Symfony\Component\HttpFoundation\Response;

class RentalSpaceApprovalController extends Controller
{
    /**
     * @param $rentalSpaceId
     * @param RentalSpaceApprovalRequest $request
     * @return JsonResponse
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     * @throws \App\Bundle\Common\Domain\Model\TransactionException
     */
    public function putRentalSpaceApproval($rentalSpaceId, RentalSpaceApprovalRequest $request): JsonResponse
    {
        if (auth()->user()->type !== 'admin') {
            return response()->json([
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'msg' => CommonConstant::MSG_EXISTS,
            ]);
        }

        $rentalSpaceApprovalRepository = new RentalSpaceApprovalRepository();
        $postRentalSpaceApprovalApplicationService = new RentalSpacePutApprovalApplicationService(
            $rentalSpaceApprovalRepository
        );
        $command = new RentalSpacePutApprovalCommand(
            $rentalSpaceId,
            $request->status
        );
        $rentalSpace = $postRentalSpaceApprovalApplicationService->handle($command);
        $response = [
            'rental_space_id' => $rentalSpace->rentalSpaceId,
            'draft_step' => $rentalSpace->draftStep,
        ];
        return response()->json($response, 200);
    }

    /**
     * Detail Approval
     * @param $rentalSpaceId
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    public function detailRentalSpaceApproval($rentalSpaceId): JsonResponse
    {
        $rentalSpaceApprovalRepository = new RentalSpaceApprovalRepository();
        $detailRentalSpaceApprovalApplicationService = new RentalSpaceGetDetailApprovalApplicationService(
            $rentalSpaceApprovalRepository
        );

        $command = new RentalSpaceGetDetailApprovalCommand($rentalSpaceId);
        $approval = $detailRentalSpaceApprovalApplicationService->handle($command);

        $systemConfigRepository = new SystemConfigRepository();
        $applicationService = new SystemConfigGetApplicationService(
            $systemConfigRepository
        );

        $commandSystem = new SystemConfigGetCommand(null);
        $result = $applicationService->handle($commandSystem);

        $response = [
            'rental_space_id' => $approval->rentalSpaceId->getValue(),
            'max_rental_plans_count' => $result->maxRentalPlansCount,
            'status' => $approval->status
        ];

        return response()->json(['status' => 200, 'data' => $response]);
    }
}
