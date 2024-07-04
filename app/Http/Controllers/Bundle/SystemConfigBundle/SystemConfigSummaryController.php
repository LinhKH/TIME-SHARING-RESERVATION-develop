<?php

namespace App\Http\Controllers\Bundle\SystemConfigBundle;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryDeleteImageApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryDeleteImageCommand;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryDeleteApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryDeleteCommand;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryGetDetailApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryGetDetailCommand;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryGetListApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryGetListCommand;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryPostCreateApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryPostCreateCommand;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryPostUploadImageApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryPostUploadImageCommand;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryPutUpdateApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryPutUpdateCommand;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryPutUpdateImageApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigSummaryPutUpdateImageCommand;
use App\Bundle\SystemConfigBundle\Infrastructure\SystemConfigSummaryRepository;
use App\Http\Requests\SystemConfigSummaryImageUpdateRequest;
use App\Http\Requests\SystemConfigSummaryImageUploadRequest;
use App\Http\Requests\SystemConfigSummaryPostRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SystemConfigSummaryController
{
    /**
     * @param SystemConfigSummaryPostRequest $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     */
    public function addSummaryAction(SystemConfigSummaryPostRequest $request): JsonResponse
    {
        $command = new SystemConfigSummaryPostCreateCommand(
            $request->active,
            $request->access_key,
            $request->title_ja,
            $request->use_purpose_category,
            $request->subtitle_ja,
            $request->catch_ja,
            $request->summary_ja,
            $request->area_id,
            $request->last_update,
            $request->meta_keywords,
            $request->meta_description,
            json_encode($request->rental_space_id)
        );
        $systemConfigSummaryRepository = new SystemConfigSummaryRepository();
        $application = new SystemConfigSummaryPostCreateApplicationService($systemConfigSummaryRepository);
        $result = $application->handle($command);
        return response()->json(['rental_space_compilation_id' => $result->rentalSpaceCompilationId], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function manageSummaryAction(Request $request): JsonResponse
    {
        $command = new SystemConfigSummaryGetListCommand(
            !empty($request['page']) ? (int)$request['page'] : 1
        );
        $systemConfigSummaryRepository = new SystemConfigSummaryRepository();
        $application = new SystemConfigSummaryGetListApplicationService($systemConfigSummaryRepository);
        $result = $application->handle($command);
        $resultRentalCompilations = [];
        if (!empty($result->resultRentalCompilation)) {
            foreach ($result->resultRentalCompilation as $resultRentalCompilation) {
                $rentalSpaceCompilationImages = [];
                if ($resultRentalCompilation->rentalSpaceCompilationImages) {
                    foreach ($resultRentalCompilation->rentalSpaceCompilationImages as $rentalSpaceCompilationImage) {
                        $rentalSpaceCompilationImages[] = [
                            'rental_space_compilation_image_id' => $rentalSpaceCompilationImage->rentalSpaceCompilationImageId,
                            'creation_time' => $rentalSpaceCompilationImage->creationTime,
                            'name' => $rentalSpaceCompilationImage->name,
                            'type' => $rentalSpaceCompilationImage->type,
                            'width' => $rentalSpaceCompilationImage->width,
                            'height' => $rentalSpaceCompilationImage->height,
                            'length' => $rentalSpaceCompilationImage->length,
                            'extension' => $rentalSpaceCompilationImage->extension,
                            's3key' => $rentalSpaceCompilationImage->s3key,
                            'parent_id' => $rentalSpaceCompilationImage->parentId,
                        ];
                    }
                }
                $resultRentalCompilations[] = [
                    'rental_space_compilation_id' => $resultRentalCompilation->rentalSpaceCompilationId,
                    'active' => $resultRentalCompilation->isActive,
                    'access_key' => $resultRentalCompilation->accessKey,
                    'order_number' => $resultRentalCompilation->orderNumber,
                    'title_ja' => $resultRentalCompilation->titleJa,
                    'use_purpose_category' => $resultRentalCompilation->usePurposeCategory,
                    'subtitle_ja' => $resultRentalCompilation->subtitleJa,
                    'catch_ja' => $resultRentalCompilation->catchJa,
                    'summary_ja' => $resultRentalCompilation->summaryJa,
                    'area_id' => $resultRentalCompilation->areaId,
                    'last_update' => $resultRentalCompilation->lastUpdate,
                    'meta_keywords' => $resultRentalCompilation->metaKeyword,
                    'meta_description' => $resultRentalCompilation->metaDescription,
                    'rental_space_id' => json_decode($resultRentalCompilation->rentalSpaceIds),
                    'rental_space_compilation_images' => $rentalSpaceCompilationImages
                ];
            }
        }

        return response()->json([
            'pagination' => [
                'total_page' => $result->paginationResult->totalPage,
                'per_page' => $result->paginationResult->perPage,
                'current_page' => $result->paginationResult->currentPage
            ],
            'data' => $resultRentalCompilations
        ], 200);
    }

    /**
     * @param $rentalSpaceCompilationId
     * @return JsonResponse
     * @throws InvalidArgumentException|RecordNotFoundException
     */
    public function detailSummaryAction($rentalSpaceCompilationId): JsonResponse
    {
        $command = new SystemConfigSummaryGetDetailCommand(
            $rentalSpaceCompilationId
        );
        $systemConfigSummaryRepository = new SystemConfigSummaryRepository();
        $application = new SystemConfigSummaryGetDetailApplicationService($systemConfigSummaryRepository);
        $result = $application->handle($command);
        $rentalSpaceCompilationImages = [];
        if ($result->rentalSpaceCompilationImages) {
            foreach ($result->rentalSpaceCompilationImages as $rentalSpaceCompilationImage) {
                $rentalSpaceCompilationImages[] = [
                    'rental_space_compilation_image_id' => $rentalSpaceCompilationImage->rentalSpaceCompilationImageId,
                    'creation_time' => $rentalSpaceCompilationImage->creationTime,
                    'name' => $rentalSpaceCompilationImage->name,
                    'type' => $rentalSpaceCompilationImage->type,
                    'width' => $rentalSpaceCompilationImage->width,
                    'height' => $rentalSpaceCompilationImage->height,
                    'length' => $rentalSpaceCompilationImage->length,
                    'extension' => $rentalSpaceCompilationImage->extension,
                    's3key' => $rentalSpaceCompilationImage->s3key,
                    'parent_id' => $rentalSpaceCompilationImage->parentId,
                ];
            }
        }
        $data = [
            'rental_space_compilation_id' => $result->rentalSpaceCompilationId,
            'active' => $result->isActive,
            'access_key' => $result->accessKey,
            'order_number' => $result->orderNumber,
            'title_ja' => $result->titleJa,
            'use_purpose_category' => $result->usePurposeCategory,
            'subtitle_ja' => $result->subtitleJa,
            'catch_ja' => $result->catchJa,
            'summary_ja' => $result->summaryJa,
            'area_id' => $result->areaId,
            'last_update' => $result->lastUpdate,
            'meta_keywords' => $result->metaKeyword,
            'meta_description' => $result->metaDescription,
            'rental_space_id' => json_decode($result->rentalSpaceIds),
            'rental_space_compilation_images' => $rentalSpaceCompilationImages
        ];
        return response()->json($data, 200);
    }

    /**
     * @param $rentalSpaceCompilationId
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    public function deleteSummaryAction($rentalSpaceCompilationId): JsonResponse
    {
        $command = new SystemConfigSummaryDeleteCommand($rentalSpaceCompilationId);
        $systemConfigSummaryRepository = new SystemConfigSummaryRepository();
        $application = new SystemConfigSummaryDeleteApplicationService($systemConfigSummaryRepository);
        $result = $application->handle($command);
        $message = "Removing the system config summary failed";
        if ($result->isSuccess) {
            $message = "Removing the system config summary successfully";
        }
        return response()->json([
            'message' => $message
        ], 200);
    }

    /**
     * @param $rentalSpaceCompilationId
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function updateSummaryAction($rentalSpaceCompilationId, Request $request): JsonResponse
    {
        $command = new SystemConfigSummaryPutUpdateCommand(
            $rentalSpaceCompilationId,
            $request->active,
            $request->access_key,
            $request->title_ja,
            $request->use_purpose_category,
            $request->subtitle_ja,
            $request->catch_ja,
            $request->summary_ja,
            $request->area_id,
            $request->last_update,
            $request->meta_keywords,
            $request->meta_description,
            json_encode($request->rental_space_id)
        );
        $systemConfigSummaryRepository = new SystemConfigSummaryRepository();
        $application = new SystemConfigSummaryPutUpdateApplicationService($systemConfigSummaryRepository);
        $result = $application->handle($command);
        return response()->json([
            'rental_space_compilation_id' => $result->rentalSpaceCompilationId
        ], 200);
    }

    /**
     * @param $rentalSpaceCompilationId
     * @param SystemConfigSummaryImageUploadRequest $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    function uploadImageSummaryAction($rentalSpaceCompilationId, SystemConfigSummaryImageUploadRequest $request): JsonResponse
    {
        $command = new SystemConfigSummaryPostUploadImageCommand(
            $rentalSpaceCompilationId,
            $request->name,
            $request->type,
            $request->width,
            $request->height,
            $request->length,
            $request->extension,
            $request->s3key,
        );
        $systemConfigSummaryRepository = new SystemConfigSummaryRepository();
        $application = new SystemConfigSummaryPostUploadImageApplicationService($systemConfigSummaryRepository);
        $result = $application->handle($command);
        return response()->json([
            'rental_space_compilation_image_id' => $result->rentalSpaceCompilationImageId
        ], 200);
    }

    /**
     * @param $rentalSpaceCompilationImageId
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    public function removeImageSummaryAction($rentalSpaceCompilationImageId): JsonResponse
    {
        $command = new SystemConfigSummaryDeleteImageCommand($rentalSpaceCompilationImageId);
        $systemConfigSummaryRepository = new SystemConfigSummaryRepository();
        $application = new SystemConfigSummaryDeleteImageApplicationService($systemConfigSummaryRepository);
        $result = $application->handle($command);
        $message = "Removing the system config summary image failed";
        if ($result->isSuccess) {
            $message = "Removing the system config summary image successfully";
        }
        return response()->json(['message' => $message], 200);
    }

    /**
     * @param $rentalSpaceCompilationImageId
     * @param SystemConfigSummaryImageUpdateRequest $request
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    public function updateImageSummaryAction($rentalSpaceCompilationImageId, SystemConfigSummaryImageUpdateRequest $request): JsonResponse
    {
        $command = new SystemConfigSummaryPutUpdateImageCommand(
            $rentalSpaceCompilationImageId,
            $request->type
        );

        $systemConfigSummaryRepository = new SystemConfigSummaryRepository();
        $application = new SystemConfigSummaryPutUpdateImageApplicationService($systemConfigSummaryRepository);
        $result = $application->handle($command);
        return response()->json([
            'rental_space_compilation_image_id' => $result->rentalSpaceCompilationImageId
        ], 200);
    }
}
