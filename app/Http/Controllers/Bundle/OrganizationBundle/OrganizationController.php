<?php

namespace App\Http\Controllers\Bundle\OrganizationBundle;

use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\OrganizationBundle\Application\OrganizationGetApplicationService;
use App\Bundle\OrganizationBundle\Application\OrganizationGetCommand;
use App\Bundle\OrganizationBundle\Application\OrganizationPostApplicationService;
use App\Bundle\OrganizationBundle\Application\OrganizationPostCommand;
use App\Bundle\OrganizationBundle\Infrastructure\OrganizationRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{

    /**
     * @param OrganizationRequest $request
     * @return JsonResponse
     * @throws TransactionException
     */
    public function addAction(OrganizationRequest $request): JsonResponse
    {
        $organizationRepository = new OrganizationRepository();
        $applicationService = new OrganizationPostApplicationService(
            $organizationRepository
        );

        $command = new OrganizationPostCommand(
            $request->name,
            $request->name_furigana,
            $request->note,
            $request->active
        );

        $result = $applicationService->handle($command);

        return response()->json(['organization_id' => $result->organizationId], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws RecordNotFoundException
     */
    public function viewAction(Request $request): JsonResponse
    {
        $organizationRepository = new OrganizationRepository();
        $applicationService = new OrganizationGetApplicationService(
            $organizationRepository
        );

        $command = new OrganizationGetCommand((int)$request->id);
        $organization = $applicationService->handle($command);
        $data = [
            'id' => $organization->organizationId,
            'name' => $organization->name,
            'name_furigana' => $organization->nameFurigana,
            'note' => $organization->note,
            'active' => $organization->active
        ];

        return response()->json($data, 200);
    }
}
