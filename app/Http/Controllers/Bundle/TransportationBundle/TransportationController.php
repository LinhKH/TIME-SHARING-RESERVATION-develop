<?php

namespace App\Http\Controllers\Bundle\TransportationBundle;

use App\Bundle\TransportationBundle\Application\TransportationSuggestGetApplicationService;
use App\Bundle\TransportationBundle\Application\TransportationSuggestGetCommand;
use App\Bundle\TransportationBundle\Infrastructure\TransportationRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestTransportRequest;
use Illuminate\Http\JsonResponse;

class TransportationController extends Controller
{
    public function suggestTransport(SuggestTransportRequest $request): JsonResponse
    {
        $transportationRepository = new TransportationRepository();
        $applicationService = new TransportationSuggestGetApplicationService(
            $transportationRepository
        );
        $command = new TransportationSuggestGetCommand(
            $request->get('name_transportation')
        );

        $transportations = $applicationService->handle($command);
        $response = [];
        foreach ($transportations as $transportationInfor) {
            $response[] = [
                'id' => $transportationInfor->transportationId,
                'transportation_name' =>$transportationInfor->transportationName,
                'ref' => $transportationInfor->ref,
                'route' => $transportationInfor->route
            ];
        }

        return response()->json([
            "status" => 200,
            "data" => $response
        ]);
    }
}
