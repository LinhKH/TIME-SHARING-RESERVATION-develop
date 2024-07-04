<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\Common\Constants\CommonConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\OrganizationInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\PageAndEmailId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalIntervalInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceAllInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceCollection;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentBasicInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentConferenceInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentEventInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentGeneralInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentPartyInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentShareInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceEquipmentShootingInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGeneral;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGetPageAndEmailMessageAllInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageValue;
use App\Models\Area;
use App\Models\RentalSpace as ModelRentalSpace;
use App\Models\RentalSpaceEav as ModelRentalSpaceEav;
use App\Models\RentalSpaceEmailMessage;
use App\Models\RentalSpaceImage as ModelRentalSpaceImage;
use App\Models\RentalSpacePage;
use App\Models\RentalSpacePanoramaImage as ModelRentalSpacePanoramaImage;
use App\Models\RentalSpaceFacadeImage as ModelRentalSpaceFacadeImage;
use App\Models\RentalSpaceDirectionsStationImage as ModelRentalSpaceDirectionsStationImage;
use App\Models\RentalSpaceFloorPlan as ModelRentalSpaceFloorPlan;
use App\Models\RentalSpaceRentalPlan;
use App\Models\RentalSpaceRentalPlanEav;
use App\Models\RentalSpace;
use App\Models\RentalSpaceEav;
use App\Models\RentalSpaceRentalInterval;
use App\Models\TsCategorySpace;
use App\Models\TsTag;
use App\Services\CommonConstant;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class RentalSpaceRepository implements IRentalSpaceRepository
{

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceAllInformation|null
     * @throws InvalidArgumentException
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?RentalSpaceAllInformation
    {
        $rentalSpace = ModelRentalSpace::find($rentalSpaceId->getValue());
        if (!$rentalSpace) {
            return null;
        }
        $entities = ModelRentalSpaceEav::where('namespace', $rentalSpaceId->getValue())->where('type_step', 'general')->get()->toArray();

        $rentalSpaceGeneral = null;
        if (!empty($entities)) {
            $rentalSpaceGeneral = $this->generalInformation($entities, $rentalSpace);
        }

        $entitiesEquipment = ModelRentalSpaceEav::where('namespace', $rentalSpaceId->getValue())->where('type_step', 'equipment_information')->get()->toArray();
        $rentalSpaceEquipments = null;
        if (!empty($entitiesEquipment)) {
            $rentalSpaceEquipments = $this->equipmentInformation($entitiesEquipment, $rentalSpace);
        }

        $entityPlanAndInterval = RentalSpaceRentalPlan::with(['rentalSpaceRentalInterval', 'rentalSpaceRentalPlanEav'])->where('rental_space_id', $rentalSpaceId->getValue())->get()->toArray();
        $rentalSpacePlanAndInterval = null;
        if (!empty($entityPlanAndInterval)) {
            $rentalSpacePlanAndInterval = $this->planAndIntervalInformation($entityPlanAndInterval);
        }

        $entityPage = RentalSpacePage::where('rental_space_id', $rentalSpaceId->getValue())->with(['rentalSpacePageEav'])->get()->toArray();
        $rentalSpacePages = null;
        if (!empty($entityPage)) {
            $rentalSpacePages = $this->rentalSpacePageInformation($rentalSpaceId, $entityPage);
        }

        $entityEmailMessage = RentalSpaceEmailMessage::where('rental_space_id', $rentalSpaceId->getValue())->with(['rentalSpaceEmailMessageEav'])->get()->toArray();
        $rentalSpaceMessage = null;
        if (!empty($entityEmailMessage)) {
            $rentalSpaceMessage = $this->rentalSpaceEmailMessage($rentalSpaceId, $entityEmailMessage);
        }

        $entitiesImage = ModelRentalSpaceImage::where('parent_id', $rentalSpaceId->getValue())->with('rentalSpaceImageEav')->get();
        $entitiesImagePanorama = ModelRentalSpacePanoramaImage::where('parent_id', $rentalSpaceId->getValue())->with('panoramaImageEav')->get();
        $entitiesImageFacade = ModelRentalSpaceFacadeImage::where('parent_id', $rentalSpaceId->getValue())->with('rentalSpaceFacadeImageEav')->get();
        $entitiesImageDirectionStation = ModelRentalSpaceDirectionsStationImage::where('parent_id', $rentalSpaceId->getValue())->with('rentalSpaceDirectionsStationImageEav')->get();
        $entitiesImageFloorPlan = ModelRentalSpaceFloorPlan::where('parent_id', $rentalSpaceId->getValue())->with('rentalSpaceFloorPlanEav')->get();

        $resultImage = null;
        $resultImagePanorama = null;
        $resultImageFacade = null;
        $resultImageDirectionStation = null;
        $resultImageFloorPlan = null;
        if (!empty($entitiesImage)) {
            foreach ($entitiesImage as $entity) {
                $rentalSpaceImageEav = $entity->rentalSpaceImageEav->first();
                $resultImage[] = new RentalSpaceImageValue(
                    $entity->id,
                    $entity->s3key,
                    $rentalSpaceImageEav ? $rentalSpaceImageEav->value : null,
                    RentalSpaceImageType::fromType(RentalSpaceImageType::IMAGE),
                    $entity->width,
                    $entity->height,
                    $entity->length,
                    $entity->extension,
                    $entity->order_number,
                );
            }
        }

        if (!empty($entitiesImagePanorama)) {
            foreach ($entitiesImagePanorama as $entity) {
                $panoramaImageEav = $entity->panoramaImageEav->first();
                $resultImagePanorama[] = new RentalSpaceImageValue(
                    $entity->id,
                    $entity->s3key,
                    $panoramaImageEav ? $panoramaImageEav->value : null,
                    RentalSpaceImageType::fromType(RentalSpaceImageType::IMAGE_PANORAMA),
                    $entity->width,
                    $entity->height,
                    $entity->length,
                    $entity->extension,
                    $entity->order_number,
                );
            }
        }

        if (!empty($entitiesImageFacade)) {
            foreach ($entitiesImageFacade as $entity) {
                $facadeImageEav = $entity->rentalSpaceFacadeImageEav->first();
                $resultImageFacade[] = new RentalSpaceImageValue(
                    $entity->id,
                    $entity->s3key,
                    $facadeImageEav ? $facadeImageEav->value : null,
                    RentalSpaceImageType::fromType(RentalSpaceImageType::IMAGE_FACADE),
                    $entity->width,
                    $entity->height,
                    $entity->length,
                    $entity->extension,
                    $entity->order_number,
                );
            }
        }
        if (!empty($entitiesImageDirectionStation)) {
            foreach ($entitiesImageDirectionStation as $entity) {
                $directionStationImageEav = $entity->rentalSpaceDirectionsStationImageEav->first();
                $resultImageDirectionStation[] = new RentalSpaceImageValue(
                    $entity->id,
                    $entity->s3key,
                    $directionStationImageEav ? $directionStationImageEav->value : null,
                    RentalSpaceImageType::fromType(RentalSpaceImageType::IMAGE_DIRECTION_STATION),
                    $entity->width,
                    $entity->height,
                    $entity->length,
                    $entity->extension,
                    $entity->order_number,
                );
            }
        }
        if (!empty($entitiesImageFloorPlan)) {
            foreach ($entitiesImageDirectionStation as $entity) {
                $floorPlanImageEav = $entity->rentalSpaceFloorPlanEav->first();
                $resultImageFloorPlan[] = new RentalSpaceImageValue(
                    $entity->id,
                    $entity->s3key,
                    $floorPlanImageEav ? $floorPlanImageEav->value : null,
                    RentalSpaceImageType::fromType(RentalSpaceImageType::IMAGE_FLOOR_PLAN),
                    $entity->width,
                    $entity->height,
                    $entity->length,
                    $entity->extension,
                    $entity->order_number,
                );
            }
        }

        return new RentalSpaceAllInformation(
            $rentalSpaceId,
            $rentalSpaceGeneral,
            $resultImage,
            $rentalSpaceEquipments,
            $rentalSpacePlanAndInterval,
            $rentalSpacePages,
            $rentalSpaceMessage,
            $resultImagePanorama,
            $resultImageFacade,
            $resultImageDirectionStation,
            $resultImageFloorPlan
        );
    }

    /**
     * get General Information
     */
    private function generalInformation($entities, $rentalSpace)
    {
        $dataRentalSpaceEav = [];
        foreach ($entities as $entity) {
            $dataRentalSpaceEav[$entity['attribute']] = $entity['value'];
        }

        return new RentalSpaceGeneral(
            $rentalSpace->organization_id,
            $dataRentalSpaceEav['generalBasicSpaceNameJa'],
            $dataRentalSpaceEav['generalBasicSpaceNameKana'] ?? null,
            $dataRentalSpaceEav['generalBasicSpaceOverview'] ?? null,
            $dataRentalSpaceEav['generalBasicSpaceIntroduction'],
            json_decode($dataRentalSpaceEav['generalBasicSpacePurposeOfUses']) ?? [],
            $dataRentalSpaceEav['generalLocationPostCode'],
            $dataRentalSpaceEav['generalLocationPrefecture'],
            $dataRentalSpaceEav['generalLocationMunicipality'],
            $dataRentalSpaceEav['generalLocationAddressJa'],
            $dataRentalSpaceEav['generalLocationAccessInstructionJa'],
            $dataRentalSpaceEav['generalLocationLatitude'] ?? null,
            $dataRentalSpaceEav['generalLocationLongitude'] ?? null,
            $dataRentalSpaceEav['generalSpaceInformationMinimumCapacity'],
            $dataRentalSpaceEav['generalSpaceInformationMaximumCapacity'],
            $dataRentalSpaceEav['generalSpaceInformationSpaciousnessDescriptionJa'],
            $dataRentalSpaceEav['generalSpaceInformationPlanJa'],
            $dataRentalSpaceEav['generalSpaceInformationMovie'] ?? null,
            $dataRentalSpaceEav['generalSpaceInformationMinimumDurationMinutes'] ?? null,
            $dataRentalSpaceEav['generalSpaceInformationMaximumBudget'] ?? null,
            $dataRentalSpaceEav['generalSpaceInformationCheapestPriceGuarantee'] ?? null,
            $dataRentalSpaceEav['generalSpaceInformationTermsOfService'],
            $dataRentalSpaceEav['generalSpaceInformationCancellationPolicy'],
            json_decode($dataRentalSpaceEav['generalSpaceInformationCancellationFeeRules'] ?? [], true),
            $dataRentalSpaceEav['generalContactOperatingCompanyJa'] ?? null,
            $dataRentalSpaceEav['generalContactOperatingCompanyJa'] ?? null,
            $dataRentalSpaceEav['generalContactPhoneNumberJa'],
            $dataRentalSpaceEav['generalContactEmail'],
        );
    }

    /**
     * Get equipment information
     * @throws InvalidArgumentException
     */
    private function equipmentInformation($entities, $rentalSpace)
    {
        $dataRentalSpaceEav = [];
        foreach ($entities as $entity) {
            $dataRentalSpaceEav[$entity['attribute']] = $entity['value'];
        }


        $rentalSpaceEquipmentBasicInformation = new RentalSpaceEquipmentBasicInformation(
            $dataRentalSpaceEav['equipmentInformation__bringingInFoodAndDrink'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__smoking'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__parking'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__numberOfParkingLot'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__neighborhoodPayParking'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__distanceToPaidParking'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__flowToUse'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__luggageStorageSupport'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__takkyubinReceiptCorrespondence'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__numberOfTable'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__numberOfChair'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__numberOfSofaSeat'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__previewSupport'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__commercialUse'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__accompaniedByPet'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__staffResident'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__affiliatedRestaurant'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__affiliatedParkingLot'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__barrierFree'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__peripheralConvenienceStore'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__distanceToConvenienceStore'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__surroundingSupermarket'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__distanceToTheSupermarket'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__beverageVendingMachine'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__tobaccoVendingMachine'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__other'] ?? null
        );

        $rentalSpaceEquipmentGeneralInformation = new RentalSpaceEquipmentGeneralInformation(
            $dataRentalSpaceEav['equipmentInformation__wifi'],
            $dataRentalSpaceEav['equipmentInformation__audioSpeaker'],
            $dataRentalSpaceEav['equipmentInformation__monitor'],
            $dataRentalSpaceEav['equipmentInformation__toilet'],
            $dataRentalSpaceEav['equipmentInformation__kitchen'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__refrigerator'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__freezer'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__iceMachine'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__airConditioner'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__elevator'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__tvSet'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__soundProofingEquipment'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__karaoke'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__microphone'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__DVDPlayer'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__projector'] ?? null
        );

        $rentalSpaceEquipmentConferenceInformation = new RentalSpaceEquipmentConferenceInformation(
            $dataRentalSpaceEav['whiteboard'] ?? null,
            $dataRentalSpaceEav['copierOrMultifunctionMachine'] ?? null,
            $dataRentalSpaceEav['moderator'] ?? null
        );

        $rentalSpaceEquipmentShootingInformation = new RentalSpaceEquipmentShootingInformation(
            $dataRentalSpaceEav['equipmentInformation__waitingRoomOrMakeupRoom'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__lightingSpotlight'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__terrace'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__pool'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__electricCapacityType'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__electricCapacity'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__largeParkingLot'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__tripod'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__reflector'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__ancillaryServices'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__birdEyeViewShooting'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__whiteHorizont'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__R_Horizont'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__bullbackShooting'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__rooftop'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__veranda'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__balcony'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__japaneseStyleRoom'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__hearth'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__atrium'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__spiralStaircase'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__bathtub'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__gardenOrLawn'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__barCounter'] ?? null
        );

        $rentalSpaceEquipmentEventInformation = new RentalSpaceEquipmentEventInformation(
            $dataRentalSpaceEav['equipmentInformation__stage'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__fullLengthMirror'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__showerRoom'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__piano'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__drumSet'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__DJ_Booth'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__wallMirrored'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__yogaMat'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__rentalShoes'] ?? null
        );

        $rentalSpaceEquipmentPartyInformation = new RentalSpaceEquipmentPartyInformation(
            $dataRentalSpaceEav['equipmentInformation__partGame'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__plate'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__glass'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__chopsticks'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__cutlery'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__stove'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__kitchenKnife'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__microwave'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__fryingPan'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__pot'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__grilledFish'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__oven'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__riceCooker'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__coffeeMaker'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__toaster'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__wineCellar'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__BBQ_Stove'] ?? null
        );
        $rentalSpaceEquipmentShareInformation = new RentalSpaceEquipmentShareInformation(
            $dataRentalSpaceEav['equipmentInformation__treatmentTable'] ?? null,
            $dataRentalSpaceEav['equipmentInformation__waterServer'] ?? null
        );

        return new RentalSpaceEquipmentInformation(
            new RentalSpaceId($rentalSpace->organization_id),
            $rentalSpaceEquipmentBasicInformation,
            $rentalSpaceEquipmentGeneralInformation,
            $rentalSpaceEquipmentConferenceInformation,
            $rentalSpaceEquipmentShootingInformation,
            $rentalSpaceEquipmentEventInformation,
            $rentalSpaceEquipmentPartyInformation,
            $rentalSpaceEquipmentShareInformation
        );
    }

    /**
     * Get plan and interval information
     */
    private function planAndIntervalInformation($entities)
    {
        $result = [];

        foreach ($entities as $entity) {
            $rentalInterval = [];
            $planName = '';
            foreach ($entity['rental_space_rental_interval'] as $interval) {
                $rentalInterval[] = new RentalIntervalInformation(
                    $interval['id'],
                    json_decode($interval['applicability_periods'] ?? ''),
                    $interval['end_time_formatted'],
                    $interval['start_time_formatted'],
                    $interval['holiday_applicability_type'],
                    $interval['status'],
                    $interval['tenancy_price'] ?? null,
                    $interval['tenancy_price_with_fraction'] ?? null,
                    $interval['per_person_price'] ?? null,
                    $interval['per_person_price_with_fraction'] ?? null,
                    $interval['maximum_simultaneous_reservations'] ?? null,
                    $interval['maximum_simultaneous_people'] ?? null
                );
            }
            foreach ($entity['rental_space_rental_plan_eav'] as $planEav) {
                if ($planEav['attribute'] === 'plan_name') {
                    $planName = $planEav['value'];
                }
            }
            $result[] = [
                'rentalPlanId' => $entity['id'],
                'rentalPlanName' => $planName,
                "rentalIntervals" => $rentalInterval
            ];
        }
        return $result;
    }

    /**
     * Rental Space Page And Email Message
     * @throws InvalidArgumentException
     */
    private function rentalSpacePageInformation($rentalSpaceId, $entities)
    {

        $pages = [];
        foreach ($entities as $entity) {
            if (!empty($entity['rental_space_page_eav'])) {
                foreach ($entity['rental_space_page_eav'] as $item) {
                    $pages[] = new RentalSpaceGetPageAndEmailMessageAllInformation(
                        new PageAndEmailId($entity['id']),
                        $entity['type'],
                        $item['value'],
                        null
                    );
                }
            }
        }

        return $pages;
    }

    /**
     * Rental Space Email Message
     * @throws InvalidArgumentException
     */
    private function rentalSpaceEmailMessage($rentalSpaceId, $entities): array
    {
        $emailMessages = [];
        foreach ($entities as $entity) {
            if (!empty($entity['rental_space_email_message_eav'])) {
                foreach ($entity['rental_space_email_message_eav'] as $item) {
                    $emailMessages[] = new RentalSpaceGetPageAndEmailMessageAllInformation(
                        new PageAndEmailId($entity['id']),
                        $entity['type'],
                        $item['value'],
                        null
                    );
                }
            }
        }

        return $emailMessages;
    }

    /**
     * @param OrganizationId $organizationId
     * @return RentalSpaceCollection[]|null
     * @throws InvalidArgumentException
     */
    public function getListIdByOrganizationId(OrganizationId $organizationId): ?array
    {
        $result = [];
        $entities = ModelRentalSpace::where('organization_id', $organizationId->getValue())->with('rentalSpaceEav')->get();
        if (empty($entities->toArray())) {
            return null;
        }
        foreach ($entities as $entity) {
            $rentalSpaceEaves = $entity['rentalSpaceEav'];
            $organizations = $entity['organizations'];
            $title = null;
            foreach ($rentalSpaceEaves as $rentalSpaceEav) {
                if ($rentalSpaceEav->attribute != CommonConst::TITLE_JA) {
                    continue;
                }
                $title = $rentalSpaceEav->value;
            }
            $organization_name = null;
            $organization_name_furigana = null;
            $organization_info = $organizations->company_information;
            if (!empty($organization_info)) {
                $organization_name = empty(json_decode($organization_info)->name) ? null : json_decode($organization_info)->name;
                $organization_name_furigana = empty(json_decode($organization_info)->name_furigana) ? null : json_decode($organization_info)->name_furigana;
            }


            $result[] = new RentalSpaceCollection(
                new RentalSpaceId($entity->id),
                new \App\Bundle\RentalSpaceBundle\Domain\Model\OrganizationId($entity->organization_id),
                new OrganizationInformation($organization_name, $organization_name_furigana),
                $entity->status,
                $title,
                RentalSpaceDraftStep::fromType($entity->draft_step)->getValue(),
                $entity->tour_flg ?? null
            );
        }
        return $result;
    }

    public function updateTourSetting(array $rentalSpaceUpdate, array $rentalSpaceInOrganization): bool
    {
        $rentalSpaceUpdateValue = [];
        $rentalSpaceInOrganizationValue = [];
        foreach ($rentalSpaceUpdate as $rentalSpaceId) {
            $rentalSpaceUpdateValue[] = $rentalSpaceId->getValue();
        }
        foreach ($rentalSpaceInOrganization as $rentalSpaceId) {
            $rentalSpaceInOrganizationValue[] = $rentalSpaceId->getValue();
        }
        $noUpdateRentalSpace = array_diff($rentalSpaceInOrganizationValue, $rentalSpaceUpdateValue);
        $updateRentalSpace = array_intersect($rentalSpaceUpdateValue, $rentalSpaceInOrganizationValue);
        ModelRentalSpace::whereIn('id', $noUpdateRentalSpace)->update([
            'tour_flg' => 0
        ]);
        ModelRentalSpace::whereIn('id', $updateRentalSpace)->update([
            'tour_flg' => 1
        ]);

        return true;
    }

    /**
     * @param int $rental_plan_id
     *
     * @return array
     */
    public function getPaymentMethodOnRentalSpaceRentalPlanEav(int $rental_plan_id): array
    {
        $query = RentalSpaceRentalPlanEav::where('namespace', $rental_plan_id)->where('attribute', 'like', "%payment_method%")->get();

        return $query->toArray();
    }

    public function getListRentalSpaceFE($filter)
    {
        if (!empty($filter['status'])) {
            $query = RentalSpace::select('id', 'status', 'user_id', 'created_at', 'area_id', 'ts_category_spaces_id')->with('rentalSpaceImage');
        } else {
            $query = RentalSpace::where('status', RentalSpace::RENTAL_SPACE_STATUS_PUBLISHED)->select('id', 'status', 'user_id', 'created_at', 'area_id', 'ts_category_spaces_id')->with('rentalSpaceImage');
        }

        $query->with(
            [
                'rentalSpaceEav' => function ($q) {
                    $q->where('attribute', "generalBasicSpaceNameJa")->orWhere('attribute', "generalSpaceInformationMaximumCapacity")->orWhere('attribute', "generalBasicSpaceIntroduction");
                },

                'rentalSpaceRentalPlan' => function ($q) {
                    $q->select('id', 'rental_space_id');
                },

                'areas' => function ($q) {
                    $q->select('id', 'name');
                },

                'user' => function ($q) {
                    $q->select('id', 'type');
                }
            ]
        );

        $query->FilterArea($filter);
        $query->FilterCategory($filter);
        $query->FilterPeopleCount($filter);
        $query->FilterTitle($filter);
        $query->FilterDate($filter);
        $query->FilterStatus($filter);

        if (!empty($filter['created_at'])) {
            $query->FilterOrderByCreatedAt($filter);
        } else {
            $query->orderBy('id', 'DESC');
        }

        if (!empty($filter['no_paginate'])) {
            return ['data' => $this->handleGetDetailRentalSpaceFE($query->get()->toArray())];
        } else {
            return $this->paginate($this->handleGetDetailRentalSpaceFE($query->get()->toArray()));
        }
    }

    public function paginate($items, $perPage = CommonConstant::PAGINATE_LIMIT_SPACE_WP, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        $data = new Collection();
        foreach ($items->forPage($page, $perPage) as $item) {
            $data->add($item);
        }

        return new LengthAwarePaginator($data, $items->count(), $perPage, $page, $options);
    }

    /**
     * @param $data
     *
     * @return array
     */
    public function handleGetDetailRentalSpaceFE($data): array
    {
        $arr = [];
        foreach ($data as $value) {

            if (!empty($value['rental_space_eav'])) {
                foreach ($value['rental_space_eav'] as $item) {

                    switch ($item['attribute']) {
                        case 'generalBasicSpaceNameJa':
                            $value['generalBasicSpaceNameJa'] = $item['value'];
                            break;

                        case 'generalBasicSpaceIntroduction':
                            $value['generalBasicSpaceIntroduction'] = $item['value'];
                            break;

                        case 'generalSpaceInformationMaximumCapacity':
                            $value['generalSpaceInformationMaximumCapacity'] = $item['value'];
                            break;
                    }
                }
            } else {
                $value['generalBasicSpaceNameJa'] = null;
                $value['generalBasicSpaceIntroduction'] = null;
                $value['generalSpaceInformationMaximumCapacity'] = null;
            }

            $idsPlan = RentalSpaceRentalPlan::where('rental_space_id', $value['id'])->get()->pluck('id')->toArray();
            $dataInterval = RentalSpaceRentalInterval::whereIn('rental_plan_id', $idsPlan)->get();
            $value['per_person_price'] = $dataInterval->min('per_person_price');
            $value['maximum_simultaneous_people'] = $dataInterval->min('maximum_simultaneous_people');
            unset($value['rental_space_eav'], $value['rental_space_rental_plan']);

            $value['ts_category_space'] = null;
            if (!empty($value['ts_category_spaces_id'])) {
                $tsCategorySpace = TsCategorySpace::whereIn('id', $value['ts_category_spaces_id'])->get(['id', 'name'])->toArray();
                $value['ts_category_space'] = $tsCategorySpace;
            }

            if ($value['rental_space_image']) {
                $convertImageSpace = [];
                foreach ($value['rental_space_image'] as $image) {
                    $image['url_image'] = Storage::url($image['s3key']);
                    $convertImageSpace[] = $image;
                }

                $value['rental_space_image'] = $convertImageSpace;
            }

            $arr[] = $value;
        }

        return $arr;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getInfoTsRentalSpaceEav(int $id): array
    {
        $data = RentalSpaceEav::where('namespace', $id)->where('attribute',  'like', "%ts%")->get();

        return $data->toArray();
    }

    /**
     * @param int $idSpace
     *
     * @return array
     */
    public function getDataTag(int $idSpace): array
    {
        $rentalSpace = ModelRentalSpace::find($idSpace);

        if (!empty($rentalSpace->ts_tag_id)) {
            return TsTag::whereIn('id', $rentalSpace->ts_tag_id)->get(['id', 'name'])->toArray();
        } else {
            return [];
        }
    }

    /**
     * @param int $idSpace
     *
     * @return ?array
     */
    public function getDataAreas(int $idSpace): ?array
    {
        $rentalSpace = ModelRentalSpace::find($idSpace);

        if (!empty($rentalSpace->area_id)) {
            $tsArea = Area::where('id', $rentalSpace->area_id)->first(['id', 'name']);
            if (!empty($tsArea)) {
                return $tsArea->toArray();
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * @param int $idSpace
     *
     * @return array
     */
    public function getDataCategorySpaces(int $idSpace): array
    {
        $rentalSpace = ModelRentalSpace::find($idSpace);
        if (!empty($rentalSpace->ts_category_spaces_id)) {
            return TsCategorySpace::whereIn('id', $rentalSpace->ts_category_spaces_id)->get(['id', 'name'])->toArray();
        } else {
            return [];
        }
    }

    public function getListRentalSpaceByCondition($filter = null)
    {
        $query = RentalSpace::select('id', 'user_id', 'status', 'created_at', 'area_id', 'ts_category_spaces_id')->with('rentalSpaceImage');

        $query->with(
            [
                'rentalSpaceEav' => function ($q) {
                    $q->where('attribute', "generalBasicSpaceNameJa")->orWhere('attribute', "generalBasicSpacePurposeOfUses")
                        ->orWhere('attribute', "generalLocationPrefecture")->orWhere('attribute', "generalLocationMunicipality")
                        ->orWhere('attribute', "generalLocationAddressJa")->orWhere('attribute', "generalLocationAccessInstructionJa")
                        ->orWhere('attribute', "generalSpaceInformationMaximumCapacity");
                },

                'rentalSpaceRentalPlan' => function ($q) {
                    $q->select('id', 'rental_space_id');
                },

                'areas' => function ($q) {
                    $q->select('id', 'name');
                },

                'user' => function ($q) {
                    $q->select('id', 'type');
                }
            ]
        );


        $query->FilterStatus($filter);

        if (!empty($filter['limit'])) {
            $query->limit($filter['limit']);
        }

        $query->orderBy('id', 'DESC');

        return $this->handleConvertListRentalSpaceEav($query->get()->toArray());
    }

    public function handleConvertListRentalSpaceEav($data)
    {
        $arr = [];
        foreach ($data as $value) {

            if (!empty($value['rental_space_eav'])) {
                foreach ($value['rental_space_eav'] as $item) {
                    switch ($item['attribute']) {
                        case 'generalBasicSpaceNameJa':
                            $value['generalBasicSpaceNameJa'] = $item['value'];
                            break;

                        case 'generalBasicSpacePurposeOfUses':
                            $value['generalBasicSpacePurposeOfUses'] = $item['value'];
                            break;

                        case 'generalLocationPrefecture':
                            $value['generalLocationPrefecture'] = $item['value'];
                            break;
                        case 'generalLocationMunicipality':
                            $value['generalLocationMunicipality'] = $item['value'];
                            break;
                        case 'generalLocationAddressJa':
                            $value['generalLocationAddressJa'] = $item['value'];
                            break;
                        case 'generalLocationAccessInstructionJa':
                            $value['generalLocationAccessInstructionJa'] = $item['value'];
                            break;
                        case 'generalSpaceInformationMaximumCapacity':
                            $value['generalSpaceInformationMaximumCapacity'] = $item['value'];
                            break;
                    }
                }
                unset($value['rental_space_eav']);
            } else {
                $value['generalBasicSpaceNameJa'] = null;
                $value['generalBasicSpacePurposeOfUses'] = null;
                $value['generalLocationPrefecture'] = null;
                $value['generalLocationMunicipality'] = null;
                $value['generalLocationAddressJa'] = null;
                $value['generalLocationAccessInstructionJa'] = null;
                $value['generalSpaceInformationMaximumCapacity'] = null;
            }

            $arr[] = $value;
        }

        return $arr;
    }
}
