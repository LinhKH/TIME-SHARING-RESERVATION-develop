<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\RentalSpaceBundle\Application\RentalSpaceEquipmentBasicInformationCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceEquipmentConferenceInformationCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceEquipmentEventInformationCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceEquipmentGeneralInformationCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceEquipmentInformationPutApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceEquipmentInformationPutCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailEquipmentInformationApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailEquipmentInformationCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostEquipmentInformationApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostEquipmentInformationCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceEquipmentPartyInformationCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceEquipmentShareInformationCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceEquipmentShootingInformationCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceEquipmentInformationRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentalSpaceEquipmentInformationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RentalSpaceEquipmentInformationController extends Controller
{

    /**
     * Create Equipment Information for Space
     *
     * @param $rentalSpaceId
     * @param RentalSpaceEquipmentInformationRequest $request
     * @return JsonResponse
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     * @throws \App\Bundle\Common\Domain\Model\TransactionException
     */
    public function postEquipmentInformation($rentalSpaceId, RentalSpaceEquipmentInformationRequest $request): JsonResponse
    {
        $rentalSpaceEquipmentInformationRepository = new RentalSpaceEquipmentInformationRepository();
        $postRentalSpaceEquipmentInformationApplicationService = new RentalSpacePostEquipmentInformationApplicationService(
            $rentalSpaceEquipmentInformationRepository
        );

        $basicInformationCommand = new RentalSpaceEquipmentBasicInformationCommand(
            $request->bringing_in_food_and_drink ?? false,
            $request->smoking ?? 'confirmation',
            $request->parking ?? false,
            $request->number_of_parking_lot ?? null,
            $request->neighborhood_pay_parking ?? false,
            $request->distance_to_paid_parking ?? null,
            $request->flow_to_use ?? null,
            $request->luggage_storage_support ?? false,
            $request->takkyubin_receipt_correspondence ?? 'impossible',
            $request->number_of_table ?? null,
            $request->number_of_chairs ?? null,
            $request->number_of_sofa_seat ?? null,
            $request->preview_support ?? false,
            $request->commercial_use ?? false,
            $request->accompanied_by_pet ?? false,
            $request->staff_resident ?? false,
            $request->affiliated_restaurant ?? false,
            $request->affiliated_parking_lot ?? false,
            $request->barrier_free ?? false,
            $request->peripheral_convenience_store ?? false,
            $request->distance_to_convenience_store ?? null,
            $request->surrounding_supermarket ?? false,
            $request->distance_to_supermarket ?? null,
            $request->beverage_vending_machine ?? false,
            $request->tobacco_vending_machine ?? false,
            $request->other ?? null
        );

        $generalInformationCommand = new RentalSpaceEquipmentGeneralInformationCommand(
            $request->wifi ?? 'NO',
            $request->audio_speaker ?? 'NO',
            $request->monitor ?? 'NO',
            $request->toilet ?? 'confirmation',
            $request->kitchen ?? false,
            $request->refrigerator ?? false,
            $request->freezer ?? false,
            $request->ice_machine ?? false,
            $request->air_conditioner ?? false,
            $request->elevator ?? false,
            $request->tvSet ?? false,
            $request->sound_proofing_equipment ?? false,
            $request->karaoke ?? false,
            $request->microphone ?? false,
            $request->DVDPlayer ?? false,
            $request->projector ?? false
        );

        $conferenceInformationCommand = new RentalSpaceEquipmentConferenceInformationCommand(
            $request->whiteboard ?? false,
            $request->copier_or_multifunction_machine ?? false,
            $request->moderator ?? false
        );

        $shootingInformationCommand = new RentalSpaceEquipmentShootingInformationCommand(
            $request->waiting_room_or_makeup_room ?? false,
            $request->lighting_spotlight ?? false,
            $request->terrace ?? false,
            $request->pool ?? false,
            $request->electric_capacity_type ?? 'A',
            $request->electric_capacity ?? null,
            $request->large_parking_lot ?? false,
            $request->tripod ?? false,
            $request->reflector ?? false,
            $request->ancillary_services ?? false,
            $request->bird_eye_view_shooting ?? false,
            $request->white_horizont ?? false,
            $request->r_horizont ?? false,
            $request->bullback_shooting ?? false,
            $request->rooftop ?? false,
            $request->veranda ?? false,
            $request->balcony ?? false,
            $request->japanese_style_room ?? false,
            $request->hearth ?? false,
            $request->atrium ?? false,
            $request->spiral_staircase ?? false,
            $request->bathtub ?? false,
            $request->garden_or_lawn ?? false,
            $request->bar_counter ?? false
        );
        $eventInformationCommand = new RentalSpaceEquipmentEventInformationCommand(
            $request->stage ?? false,
            $request->fullLength_mirror ?? false,
            $request->shower_room ?? false,
            $request->piano ?? false,
            $request->drum_set ?? false,
            $request->dj_booth ?? false,
            $request->wall_mirrored ?? false,
            $request->yoga_mat ?? false,
            $request->rental_shoes ?? false
        );
        $partyInformationCommand = new RentalSpaceEquipmentPartyInformationCommand(
            $request->part_game ?? null,
            $request->plate ?? 'confirmation',
            $request->glass ?? 'confirmation',
            $request->chopsticks ?? 'confirmation',
            $request->cutlery ?? 'confirmation',
            $request->stove ?? 'confirmation',
            $request->kitchen_knife ?? false,
            $request->pot ?? false,
            $request->frying_pan ?? false,
            $request->grilled_fish ?? false,
            $request->microwave ?? false,
            $request->oven ?? false,
            $request->rice_cooker ?? false,
            $request->coffee_maker ?? false,
            $request->toaster ?? false,
            $request->wine_cellar ?? false,
            $request->bbq_stove ?? false
        );
        $shareInformationCommand = new RentalSpaceEquipmentShareInformationCommand(
            $request->treatmentTable ?? false,
            $request->waterServer ?? false
        );
        $command = new RentalSpacePostEquipmentInformationCommand(
            $rentalSpaceId,
            $basicInformationCommand,
            $generalInformationCommand,
            $conferenceInformationCommand,
            $shootingInformationCommand,
            $eventInformationCommand,
            $partyInformationCommand,
            $shareInformationCommand
        );
        $rentalSpace = $postRentalSpaceEquipmentInformationApplicationService->handle($command);
        $response = [
            'rental_space_id' => $rentalSpace->rentalSpaceId,
            'draft_step' => $rentalSpace->draftStep,
        ];
        return response()->json($response, 200);
    }

    /**
     * GET - detail Equipment Information
     */
    public function detailEquipmentInformation($rentalSpaceId): JsonResponse
    {
        $rentalSpaceEquipmentInformationRepository = new RentalSpaceEquipmentInformationRepository();
        $detailRentalSpaceEquipmentInformationApplicationService = new RentalSpaceGetDetailEquipmentInformationApplicationService(
            $rentalSpaceEquipmentInformationRepository
        );

        $command = new RentalSpaceGetDetailEquipmentInformationCommand($rentalSpaceId);
        $equipments = $detailRentalSpaceEquipmentInformationApplicationService->handle($command);

        return response()->json(['status' => 200, 'data'=>$equipments]);
    }

    /**
     * PUT - update equipment information
     */
    public function updateEquipmentInformation($rentalSpaceId, RentalSpaceEquipmentInformationRequest $request)
    {
        $rentalSpaceEquipmentInformationRepository = new RentalSpaceEquipmentInformationRepository();
        $applicationService = new RentalSpaceEquipmentInformationPutApplicationService(
            $rentalSpaceEquipmentInformationRepository
        );

        $basicInformationCommand = new RentalSpaceEquipmentBasicInformationCommand(
            $request->bringing_in_food_and_drink ?? false,
            $request->smoking ?? 'confirmation',
            $request->parking ?? false,
            $request->number_of_parking_lot ?? null,
            $request->neighborhood_pay_parking ?? false,
            $request->distance_to_paid_parking ?? null,
            $request->flow_to_use ?? null,
            $request->luggage_storage_support ?? false,
            $request->takkyubin_receipt_correspondence ?? 'impossible',
            $request->number_of_table ?? null,
            $request->number_of_chairs ?? null,
            $request->number_of_sofa_seat ?? null,
            $request->preview_support ?? false,
            $request->commercial_use ?? false,
            $request->accompanied_by_pet ?? false,
            $request->staff_resident ?? false,
            $request->affiliated_restaurant ?? false,
            $request->affiliated_parking_lot ?? false,
            $request->barrier_free ?? false,
            $request->peripheral_convenience_store ?? false,
            $request->distance_to_convenience_store ?? null,
            $request->surrounding_supermarket ?? false,
            $request->distance_to_supermarket ?? null,
            $request->beverage_vending_machine ?? false,
            $request->tobacco_vending_machine ?? false,
            $request->other ?? null
        );

        $generalInformationCommand = new RentalSpaceEquipmentGeneralInformationCommand(
            $request->wifi ?? 'NO',
            $request->audio_speaker ?? 'NO',
            $request->monitor ?? 'NO',
            $request->toilet ?? 'confirmation',
            $request->kitchen ?? false,
            $request->refrigerator ?? false,
            $request->freezer ?? false,
            $request->ice_machine ?? false,
            $request->air_conditioner ?? false,
            $request->elevator ?? false,
            $request->tvSet ?? false,
            $request->sound_proofing_equipment ?? false,
            $request->karaoke ?? false,
            $request->microphone ?? false,
            $request->DVDPlayer ?? false,
            $request->projector ?? false
        );

        $conferenceInformationCommand = new RentalSpaceEquipmentConferenceInformationCommand(
            $request->whiteboard ?? false,
            $request->copier_or_multifunction_machine ?? false,
            $request->moderator ?? false
        );

        $shootingInformationCommand = new RentalSpaceEquipmentShootingInformationCommand(
            $request->waiting_room_or_makeup_room ?? false,
            $request->lighting_spotlight ?? false,
            $request->terrace ?? false,
            $request->pool ?? false,
            $request->electric_capacity_type ?? 'A',
            $request->electric_capacity ?? null,
            $request->large_parking_lot ?? false,
            $request->tripod ?? false,
            $request->reflector ?? false,
            $request->ancillary_services ?? false,
            $request->bird_eye_view_shooting ?? false,
            $request->white_horizont ?? false,
            $request->r_horizont ?? false,
            $request->bullback_shooting ?? false,
            $request->rooftop ?? false,
            $request->veranda ?? false,
            $request->balcony ?? false,
            $request->japanese_style_room ?? false,
            $request->hearth ?? false,
            $request->atrium ?? false,
            $request->spiral_staircase ?? false,
            $request->bathtub ?? false,
            $request->garden_or_lawn ?? false,
            $request->bar_counter ?? false
        );
        $eventInformationCommand = new RentalSpaceEquipmentEventInformationCommand(
            $request->stage ?? false,
            $request->fullLength_mirror ?? false,
            $request->shower_room ?? false,
            $request->piano ?? false,
            $request->drum_set ?? false,
            $request->dj_booth ?? false,
            $request->wall_mirrored ?? false,
            $request->yoga_mat ?? false,
            $request->rental_shoes ?? false
        );
        $partyInformationCommand = new RentalSpaceEquipmentPartyInformationCommand(
            $request->part_game ?? null,
            $request->plate ?? 'confirmation',
            $request->glass ?? 'confirmation',
            $request->chopsticks ?? 'confirmation',
            $request->cutlery ?? 'confirmation',
            $request->stove ?? 'confirmation',
            $request->kitchen_knife ?? false,
            $request->pot ?? false,
            $request->frying_pan ?? false,
            $request->grilled_fish ?? false,
            $request->microwave ?? false,
            $request->oven ?? false,
            $request->rice_cooker ?? false,
            $request->coffee_maker ?? false,
            $request->toaster ?? false,
            $request->wine_cellar ?? false,
            $request->bbq_stove ?? false
        );
        $shareInformationCommand = new RentalSpaceEquipmentShareInformationCommand(
            $request->treatmentTable ?? false,
            $request->waterServer ?? false
        );
        $command = new RentalSpaceEquipmentInformationPutCommand(
            $rentalSpaceId,
            $basicInformationCommand,
            $generalInformationCommand,
            $conferenceInformationCommand,
            $shootingInformationCommand,
            $eventInformationCommand,
            $partyInformationCommand,
            $shareInformationCommand
        );
        $rentalSpace = $applicationService->handle($command);
        return response()->json([
            'message' => 'Update successfully !',
            'rental_space_id' => $rentalSpace->rentalSpaceId
        ], 200);
    }
}
