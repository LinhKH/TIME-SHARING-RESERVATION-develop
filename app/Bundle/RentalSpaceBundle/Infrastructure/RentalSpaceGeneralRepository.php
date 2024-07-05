<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\Common\Constants\CommonConst;
use App\Bundle\Common\Constants\PaginationConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\OrganizationInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\PagePaginationCriteria;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\OrganizationId;
use App\Bundle\RentalSpaceBundle\Domain\Model\Pagination;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceApproval;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceCollection;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceGeneral;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceTypeDataEav;
use App\Models\RentalSpace as ModelRentalSpace;
use App\Models\RentalSpaceEav as ModelRentalSpaceEav;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Http\Response;
use App\Models\RentalSpaceEav;
use Illuminate\Support\Facades\Storage;

class RentalSpaceGeneralRepository implements IRentalSpaceGeneralRepository
{
    /**
     * @return RentalSpace[]
     * @throws InvalidArgumentException
     */
    public function findAll(PagePaginationCriteria $rentalSpacePaginationCriteria, $fillter): array
    {
        $entities = ModelRentalSpace::with(['rentalSpaceEav', 'organizations']);

        $entities->orderByRaw("FIELD(status , 'published') DESC");

        if (!empty($fillter['created_at'])) {
            $entities->orderby('created_at', $fillter['created_at']);
        } else {
            $entities->orderby('created_at', 'desc');
        }

        if (!empty($fillter['status'])) {
            $entities->where('status', $fillter['status']);
        }

        $entities = $entities->paginate(PaginationConst::PAGINATE_ROW);
        /** @var RentalSpace[] $result */
        $result = [];
        // dd($entities);
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
                new OrganizationId($entity->organization_id),
                new OrganizationInformation($organization_name, $organization_name_furigana),
                $entity->status ?? 'active',
                $title,
                RentalSpaceDraftStep::fromType($entity->draft_step)->getValue(),
                $entity->tour_flg ?? null
            );
        }


        // paginate
        $pagination = new Pagination(
            $entities->lastPage(),
            $entities->perPage(),
            $entities->currentPage()
        );

        return [
            $result,
            $pagination
        ];
    }

    /**
     * Create rental space general
     *
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     * @throws InvalidArgumentException
     */
    public function createRentalSpaceGeneral(RentalSpace $rentalSpace): array
    {
        $rentalSpaceModel = ModelRentalSpace::create([
            'organization_id' => $rentalSpace->getRentalSpaceGeneral()->getOrganizationId(),
            'draft_step' => $rentalSpace->getDraftStep()->nextStep()
        ]);
        $generalPurposeOfUses = [];
        foreach ($rentalSpace->getRentalSpaceGeneral()->getGeneralBasicSpacePurposeOfUses() as $generalPurposeOfUse) {
            $generalPurposeOfUses[] = [
                'mainCategory' => $generalPurposeOfUse->getMainCategory(),
                'subCategory' => $generalPurposeOfUse->getSubCategory(),
                'titleCategory' => $generalPurposeOfUse->getTitleCategory()
            ];
        }

        $generalSpaceInformationCancellationFeeRules = [];
        foreach ($rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationCancellationFeeRules() as $generalSpaceInformationCancellationFeeRule) {
            $generalSpaceInformationCancellationFeeRules[] = [
                'startDay' => $generalSpaceInformationCancellationFeeRule->getStartDay(),
                'endDay' => $generalSpaceInformationCancellationFeeRule->getEndDay(),
                'isCouponApplicable' => $generalSpaceInformationCancellationFeeRule->getIsCouponApplicable(),
                'percentage' => $generalSpaceInformationCancellationFeeRule->getPercentage()
            ];
        }


        $dataEav = [
            'generalBasicSpaceNameJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralBasicSpaceNameJa(),
            'generalBasicSpaceNameKana' => $rentalSpace->getRentalSpaceGeneral()->getGeneralBasicSpaceNameKana(),
            'generalBasicSpaceOverview' => $rentalSpace->getRentalSpaceGeneral()->getGeneralBasicSpaceOverview(),
            'generalBasicSpaceIntroduction' => $rentalSpace->getRentalSpaceGeneral()->getGeneralBasicSpaceIntroduction(),
            'generalBasicSpacePurposeOfUses' => json_encode($generalPurposeOfUses),
            'generalLocationPrefecture' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationPrefecture(),
            'generalLocationPostCode' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationPostCode(),
            'generalLocationMunicipality' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationMunicipality(),
            'generalLocationAddressJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationAddressJa(),
            'generalLocationAccessInstructionJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationAccessInstructionJa(),
            'generalLocationLatitude' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationLatitude() ?? 0,
            'generalLocationLongitude' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationLongitude() ?? 0,
            'generalSpaceInformationMinimumCapacity' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationMinimumCapacity(),
            'generalSpaceInformationMaximumCapacity' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationMaximumCapacity(),
            'generalSpaceInformationSpaciousnessDescriptionJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationSpaciousnessDescriptionJa(),
            'generalSpaceInformationPlanJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationPlanJa(),
            'generalSpaceInformationMovie' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationMovie(),
            'generalSpaceInformationMinimumDurationMinutes' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationMinimumDurationMinutes() ?? 0,
            'generalSpaceInformationMaximumBudget' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationMaximumBudget() ?? 0,
            'generalSpaceInformationCheapestPriceGuarantee' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationCheapestPriceGuarantee() ?? false,
            'generalSpaceInformationTermsOfService' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationTermsOfService(),
            'generalSpaceInformationCancellationPolicy' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationCancellationPolicy(),
            'generalSpaceInformationCancellationFeeRules' => json_encode($generalSpaceInformationCancellationFeeRules),
            'generalContactOperatingCompanyJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralContactOperatingCompanyJa(),
            'generalContactPersonInChargeJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralContactPersonInChargeJa(),
            'generalContactPhoneNumberJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralContactPhoneNumberJa(),
            'generalContactEmail' => $rentalSpace->getRentalSpaceGeneral()->getGeneralContactEmail()
        ];
        foreach ($dataEav as $key => $value) {
            if ($value != null) {
                ModelRentalSpaceEav::create([
                    'namespace' => $rentalSpaceModel->id,
                    'attribute' => $key,
                    'value' => $value,
                    'type_step' => RentalSpaceTypeDataEav::fromType(RentalSpaceTypeDataEav::GENERAL)->getValue()
                ]);
            }
        }
        return [new RentalSpaceId($rentalSpaceModel->id), new RentalSpaceDraftStep($rentalSpaceModel->draft_step)];
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceGeneral|null
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?RentalSpaceGeneral
    {
        // TODO: Implement findById() method.
        ini_set('max_execution_time', 180); // 3 minutes
        $space = ModelRentalSpace::find($rentalSpaceId->getValue());
        $entities = ModelRentalSpaceEav::where('namespace', $rentalSpaceId->getValue())->where('type_step', 'general')->get()->toArray();
        if (!$entities) {
            return null;
        }
        $dataRentalSpaceEav = [];
        foreach ($entities as $entity) {
            $dataRentalSpaceEav[$entity['attribute']] =  $entity['value'];
        }

        return new RentalSpaceGeneral(
            $space->organization_id,
            $dataRentalSpaceEav['generalBasicSpaceNameJa'],
            $dataRentalSpaceEav['generalBasicSpaceNameKana'] ?? null,
            $dataRentalSpaceEav['generalBasicSpaceOverview'] ?? null,
            $dataRentalSpaceEav['generalBasicSpaceIntroduction'],
            (isset($dataRentalSpaceEav['generalBasicSpacePurposeOfUses'])) ? json_decode($dataRentalSpaceEav['generalBasicSpacePurposeOfUses'],true) : [],
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
            json_decode($dataRentalSpaceEav['generalSpaceInformationCancellationFeeRules'] ?? '', true),
            $dataRentalSpaceEav['generalContactOperatingCompanyJa'] ?? null,
            $dataRentalSpaceEav['generalContactOperatingCompanyJa'] ?? null,
            $dataRentalSpaceEav['generalContactPhoneNumberJa'] ?? '',
            $dataRentalSpaceEav['generalContactEmail'] ?? '',
        );
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findCurrentDraftStepBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalSpace
    {
        // TODO: Implement findCurrentDraftStepBySpaceId() method.
        $entities = ModelRentalSpace::find($rentalSpaceId->getValue());
        if (!$entities) {
            return null;
        }
        return new RentalSpace(
            $rentalSpaceId,
            new RentalSpaceDraftStep($entities->draft_step),
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            new RentalSpaceApproval(
                $rentalSpaceId,
                $entities->status
            ),
            null,
        );
    }

    /**
     * API Update General Space
     * @param RentalSpace $rentalSpace
     * @return RentalSpaceId
     * @throws InvalidArgumentException
     */
    public function updateRentalSpaceGeneral(RentalSpace $rentalSpace): RentalSpaceId
    {
        $entity = ModelRentalSpace::find($rentalSpace->getRentalSpaceId()->getValue());
        $entity->update([
            'organization_id' => $rentalSpace->getRentalSpaceGeneral()->getOrganizationId()
        ]);

        ModelRentalSpaceEav::where('namespace', $rentalSpace->getRentalSpaceId()->getValue())->where('type_step', 'general')->delete();

        $generalPurposeOfUses = [];
        foreach ($rentalSpace->getRentalSpaceGeneral()->getGeneralBasicSpacePurposeOfUses() as $generalPurposeOfUse) {
            $generalPurposeOfUses[] = [
                'mainCategory' => $generalPurposeOfUse->getMainCategory(),
                'subCategory' => $generalPurposeOfUse->getSubCategory(),
                'titleCategory' => $generalPurposeOfUse->getTitleCategory(),
            ];
        }

        $generalSpaceInformationCancellationFeeRules = [];
        foreach ($rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationCancellationFeeRules() as $generalSpaceInformationCancellationFeeRule) {
            $generalSpaceInformationCancellationFeeRules[] = [
                'startDay' => $generalSpaceInformationCancellationFeeRule->getStartDay(),
                'endDay' => $generalSpaceInformationCancellationFeeRule->getEndDay(),
                'isCouponApplicable' => $generalSpaceInformationCancellationFeeRule->getIsCouponApplicable(),
                'percentage' => $generalSpaceInformationCancellationFeeRule->getPercentage()
            ];
        }


        $dataEav = [
            'generalBasicSpaceNameJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralBasicSpaceNameJa(),
            'generalBasicSpaceNameKana' => $rentalSpace->getRentalSpaceGeneral()->getGeneralBasicSpaceNameKana(),
            'generalBasicSpaceOverview' => $rentalSpace->getRentalSpaceGeneral()->getGeneralBasicSpaceOverview(),
            'generalBasicSpaceIntroduction' => $rentalSpace->getRentalSpaceGeneral()->getGeneralBasicSpaceIntroduction(),
            'generalBasicSpacePurposeOfUses' => json_encode($generalPurposeOfUses),
            'generalLocationPrefecture' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationPrefecture(),
            'generalLocationPostCode' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationPostCode(),
            'generalLocationMunicipality' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationMunicipality(),
            'generalLocationAddressJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationAddressJa(),
            'generalLocationAccessInstructionJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationAccessInstructionJa(),
            'generalLocationLatitude' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationLatitude() ?? 0,
            'generalLocationLongitude' => $rentalSpace->getRentalSpaceGeneral()->getGeneralLocationLongitude() ?? 0,
            'generalSpaceInformationMinimumCapacity' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationMinimumCapacity(),
            'generalSpaceInformationMaximumCapacity' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationMaximumCapacity(),
            'generalSpaceInformationSpaciousnessDescriptionJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationSpaciousnessDescriptionJa(),
            'generalSpaceInformationPlanJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationPlanJa(),
            'generalSpaceInformationMovie' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationMovie(),
            'generalSpaceInformationMinimumDurationMinutes' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationMinimumDurationMinutes() ?? 0,
            'generalSpaceInformationMaximumBudget' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationMaximumBudget() ?? 0,
            'generalSpaceInformationCheapestPriceGuarantee' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationCheapestPriceGuarantee() ?? false,
            'generalSpaceInformationTermsOfService' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationTermsOfService(),
            'generalSpaceInformationCancellationPolicy' => $rentalSpace->getRentalSpaceGeneral()->getGeneralSpaceInformationCancellationPolicy(),
            'generalSpaceInformationCancellationFeeRules' => json_encode($generalSpaceInformationCancellationFeeRules),
            'generalContactOperatingCompanyJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralContactOperatingCompanyJa(),
            'generalContactPersonInChargeJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralContactPersonInChargeJa(),
            'generalContactPhoneNumberJa' => $rentalSpace->getRentalSpaceGeneral()->getGeneralContactPhoneNumberJa(),
            'generalContactEmail' => $rentalSpace->getRentalSpaceGeneral()->getGeneralContactEmail()
        ];
        foreach ($dataEav as $key => $value) {
            if ($value != null) {
                ModelRentalSpaceEav::create([
                    'namespace' => $rentalSpace->getRentalSpaceId()->getValue(),
                    'attribute' => $key,
                    'value' => $value,
                    'type_step' => 'general'
                ]);
            }
        }
        return new RentalSpaceId($rentalSpace->getRentalSpaceId()->getValue());
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return bool
     */
    public function checkExistSpace(RentalSpaceId $rentalSpaceId): bool
    {
        $entity = ModelRentalSpace::find($rentalSpaceId->getValue())->exists();
        if (!$entity) {
            return false;
        }
        return true;
    }

    /**
     * @param int $id
     * @param array $dataUpdate
     *
     * @return array
     */
    public function handleUpdateInfoRentalSpaceEav($id, $dataUpdate): array
    {
        $rentalSpace = ModelRentalSpace::findOrFail($id);

        try {
            if (!empty($dataUpdate['attribute'])) {
                foreach ($dataUpdate['attribute'] as $key => $item) {
                    if ($key === 'ts_image_btk_1' || $key === 'ts_image_btk_2') {
                        if (file_exists($item)) {
                            $putFile = Storage::putFile('public/ts', $item, 'public');
                            $urlImage = Storage::url($putFile);
                            ModelRentalSpaceEav::where('namespace', $id)->where('attribute', $key)->delete();

                            $dataImage = [
                                'namespace' => $id,
                                'attribute' => $key,
                                'value' => $urlImage,
                            ];
                            RentalSpaceEav::create($dataImage);
                        }
                    } else {
                        $dataRentalSpaceEav = [
                            'namespace' => $id,
                            'attribute' => $key,
                            'value' => $item,
                        ];
                        $sql = RentalSpaceEav::where('namespace', $id)->where('attribute', $key)->first();
                        if (!empty($sql)) {
                            $sql->update($dataRentalSpaceEav);
                        } else {
                            RentalSpaceEav::create($dataRentalSpaceEav);
                        }
                    }
                }
            }

            if (!empty($dataUpdate['area_id']) || !empty($dataUpdate['ts_category_spaces_id']) || !empty($dataUpdate['ts_tag_id'])) {
                unset($dataUpdate['attribute']);
                $rentalSpace->update($dataUpdate);
            }

            if (!empty($dataUpdate['general_basic_space_name_ja'])) {
                $dataNameSpace = [
                    'namespace' => $id,
                    'attribute' => 'generalBasicSpaceNameJa',
                    'value' => $dataUpdate['general_basic_space_name_ja'],
                    'type_step' => 'general'
                ];

                $sql = RentalSpaceEav::where('namespace', $id)->where('attribute', 'generalBasicSpaceNameJa')->first();
                if (!empty($sql)) {
                    $sql->update(['value' => $dataUpdate['general_basic_space_name_ja']]);
                } else {
                    RentalSpaceEav::create($dataNameSpace);
                }
            }

            if (!empty($dataUpdate['general_basic_space_introduction'])) {
                $dataNameSpace = [
                    'namespace' => $id,
                    'attribute' => 'generalBasicSpaceIntroduction',
                    'value' => $dataUpdate['general_basic_space_introduction'],
                    'type_step' => 'general'
                ];

                $sql = RentalSpaceEav::where('namespace', $id)->where('attribute', 'generalBasicSpaceIntroduction')->first();
                if (!empty($sql)) {
                    $sql->update(['value' => $dataUpdate['general_basic_space_introduction']]);
                } else {
                    RentalSpaceEav::create($dataNameSpace);
                }
            }

            return [
                'status' => Response::HTTP_OK,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param int $id
     * @param array $user_id
     *
     * @return array
     */
    public function handleUpdateUserIdOnRentalSpace($id, $userId): array
    {
        $rentalSpace = ModelRentalSpace::findOrFail($id);

        try {
            $rentalSpace->update(['user_id' => $userId]);

            return [
                'status' => Response::HTTP_OK,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param int $rentalSpaceId
     *
     * @return string
     */
    public function getStatusSpace($rentalSpaceId): string
    {
        $rentalSpace = ModelRentalSpace::findOrFail($rentalSpaceId);

        try {
            return $rentalSpace->status;
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }
}
