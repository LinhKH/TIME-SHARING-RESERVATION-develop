<?php

namespace App\Http\Controllers\Bundle\RentalSpaceBundle;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDeleteDirectionStationImageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDeleteDirectionStationImageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDeleteFacadeImageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDeleteFacadeImageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDeleteFloorPlanImageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDeleteFloorPlanImageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDeleteImageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDeleteImageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDeletePanoramaImageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceDeletePanoramaImageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailDirectionStationImageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailDirectionStationImageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailFacadeImageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailFacadeImageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailFloorPlanApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailFloorPlanCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailImageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailImageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailPanoramaImageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceGetDetailPanoramaImageCommand;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostImageApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpacePostImageCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceImageRepository;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceImageUpdatePutApplicationService;
use App\Bundle\RentalSpaceBundle\Application\RentalSpaceImageUpdatePutCommand;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceGeneralRepository;
use App\Http\Requests\RentalSpaceImageUpdateRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentalSpaceImageRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RentalSpaceImageController extends Controller
{
    /**
     * Upload file image to storage
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postUploadImageStorage(Request $request): JsonResponse
    {
        if (!$request->hasFile('file')) {
            return response()->json([
                'status' => 400,
                'message' => 'Upload file not found'
            ], 400);
        }

        if (!$request->has('type')) {
            return response()->json([
                'status' => 400,
                'message' => 'Type of image is field require'
            ], 400);
        }

        $type = $request['type'];
        $allowedFileExtension = ['jpg', 'jpeg', 'png', 'bmp'];
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $checkExtension = in_array($extension, $allowedFileExtension);

        if (!$checkExtension) {
            return response()->json(['invalid_file_format'], 422);
        }

        $informationImage = getimagesize($file);
        $path = $file->store('public/images');

        return response()->json([
            'path_file' => $path,
            'type' => $type,
            'width' => $informationImage[0],
            'height' => $informationImage[1],
            'length' => filesize($file), //byte
            'extension' => $extension
        ]);
    }

    /**
     * Create Image
     *
     * @param $rentalSpaceId
     * @param RentalSpaceImageRequest $request
     * @return JsonResponse
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function postRentalSpaceImages($rentalSpaceId, RentalSpaceImageRequest $request): JsonResponse
    {
        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $postRentalSpaceImageApplicationService = new RentalSpacePostImageApplicationService(
            $rentalSpaceImageRepository
        );
        if (!$request->has('information_images')) {
            return response()->json([
                'status' => 400,
                'message' => 'Data of information images is array require'
            ], 400);
        }

        $informationImages = [];
        if (!empty($request->information_images)) {
            $informationImages = $request['information_images'];
        }

        $command = new RentalSpacePostImageCommand(
            $rentalSpaceId,
            $informationImages
        );

        $rentalSpaceImageRepository->deleteAllImage($rentalSpaceId);
        $rentalSpace = $postRentalSpaceImageApplicationService->handle($command);

        $response = [
            'rental_space_id' => $rentalSpace->rentalSpaceId,
            'draft_step' => $rentalSpace->draftStep,
        ];
        return response()->json($response, 200);
    }

    /**
     * Delete image in storage
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function removeImageStorage(Request $request): JsonResponse
    {
        if ($request->has('path_file') && Storage::exists($request->path_file)) {
            Storage::delete($request->path_file);
            return response()->json(['message' => "Remove Image Successfully ! "], 200);
        } else {
            return response()->json(['message' => "File Not Found ! "], 500);
        }
    }

    /**
     * GET - Detail Image for Space
     * @param $rentalSpaceId
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function detailRentalSpaceImages($rentalSpaceId): JsonResponse
    {

        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $detailRentalSpaceImageApplicationService = new RentalSpaceGetDetailImageApplicationService(
            $rentalSpaceImageRepository
        );

        $command = new RentalSpaceGetDetailImageCommand($rentalSpaceId);
        $images = $detailRentalSpaceImageApplicationService->handle($command);

        return response()->json(['status' => 200, 'data' => $images]);
    }

    /**
     * GET - Detail Image Panorama for Space
     * @param $rentalSpaceId
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function detailRentalSpacePanoramaImages($rentalSpaceId): JsonResponse
    {
        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $rentalSpaceGetPanoramaApplicationService = new RentalSpaceGetDetailPanoramaImageApplicationService(
            $rentalSpaceImageRepository
        );
        $command = new RentalSpaceGetDetailPanoramaImageCommand($rentalSpaceId);
        $images = $rentalSpaceGetPanoramaApplicationService->handle($command);
        return response()->json(['status' => 200, 'data' => $images]);
    }

    /**
     * GET - Detail Image Facade for Space
     * @param $rentalSpaceId
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function detailRentalSpaceFacadeImages($rentalSpaceId): JsonResponse
    {
        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $rentalSpaceGetDetailFacadeImageApplicationService = new RentalSpaceGetDetailFacadeImageApplicationService(
            $rentalSpaceImageRepository
        );
        $command = new RentalSpaceGetDetailFacadeImageCommand($rentalSpaceId);
        $images = $rentalSpaceGetDetailFacadeImageApplicationService->handle($command);
        return response()->json(['status' => 200, 'data' => $images]);
    }

    /**
     * GET - Detail Image Direction Station for Space
     * @param $rentalSpaceId
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function detailRentalSpaceDirectionStationImages($rentalSpaceId): JsonResponse
    {
        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $rentalSpaceGetDetailDirectionStationImageApplicationService = new RentalSpaceGetDetailDirectionStationImageApplicationService(
            $rentalSpaceImageRepository
        );
        $command = new RentalSpaceGetDetailDirectionStationImageCommand($rentalSpaceId);
        $images = $rentalSpaceGetDetailDirectionStationImageApplicationService->handle($command);
        return response()->json(['status' => 200, 'data' => $images]);
    }

    /**
     * GET - Detail Floor Plan for Space
     * @param $rentalSpaceId
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function detailRentalSpaceFloorPlan($rentalSpaceId): JsonResponse
    {
        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $rentalSpaceGetDetailFloorPlanApplicationService = new RentalSpaceGetDetailFloorPlanApplicationService(
            $rentalSpaceImageRepository
        );
        $command = new RentalSpaceGetDetailFloorPlanCommand($rentalSpaceId);
        $images = $rentalSpaceGetDetailFloorPlanApplicationService->handle($command);
        return response()->json(['status' => 200, 'data' => $images]);
    }

    /**
     * @param $imageId
     * @return JsonResponse
     * @throws TransactionException
     */
    public function deleteRentalSpaceImage($imageId): JsonResponse
    {
        $command = new RentalSpaceDeleteImageCommand(
            $imageId
        );
        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $application = new RentalSpaceDeleteImageApplicationService($rentalSpaceImageRepository);
        $result = $application->handle($command);
        return response()->json([
            'message' => $result->message
        ], 200);
    }

    /**
     * @param $imagePanoramaId
     * @return JsonResponse
     * @throws TransactionException
     */
    public function deleteRentalSpacePanoramaImage($imagePanoramaId): JsonResponse
    {
        $command = new RentalSpaceDeletePanoramaImageCommand(
            $imagePanoramaId
        );
        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $application = new RentalSpaceDeletePanoramaImageApplicationService($rentalSpaceImageRepository);
        $result = $application->handle($command);
        return response()->json([
            'message' => $result->message
        ], 200);
    }

    /**
     * @param $imageFacadeId
     * @return JsonResponse
     * @throws TransactionException
     */
    public function deleteRentalSpaceFacadeImage($imageFacadeId): JsonResponse
    {
        $command = new RentalSpaceDeleteFacadeImageCommand(
            $imageFacadeId
        );
        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $application = new RentalSpaceDeleteFacadeImageApplicationService($rentalSpaceImageRepository);
        $result = $application->handle($command);
        return response()->json([
            'message' => $result->message
        ], 200);
    }

    /**
     * @param $imageDirectionStationId
     * @return JsonResponse
     * @throws TransactionException
     */
    public function deleteRentalSpaceDirectionStationImage($imageDirectionStationId): JsonResponse
    {
        $command = new RentalSpaceDeleteDirectionStationImageCommand(
            $imageDirectionStationId
        );
        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $application = new RentalSpaceDeleteDirectionStationImageApplicationService($rentalSpaceImageRepository);
        $result = $application->handle($command);
        return response()->json([
            'message' => $result->message
        ], 200);
    }

    /**
     * @param $imageFloorPlanId
     * @return JsonResponse
     * @throws TransactionException
     */
    public function deleteRentalSpaceFloorPlanImage($imageFloorPlanId): JsonResponse
    {
        $command = new RentalSpaceDeleteFloorPlanImageCommand(
            $imageFloorPlanId
        );
        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $application = new RentalSpaceDeleteFloorPlanImageApplicationService($rentalSpaceImageRepository);
        $result = $application->handle($command);
        return response()->json([
            'message' => $result->message
        ], 200);
    }


    /**
     * update title Image With Type
     * @param $rentalSpaceId
     * @param RentalSpaceImageUpdateRequest $request
     * @return JsonResponse
     */
    public function updateRentalSpaceImageWithType($rentalSpaceId, RentalSpaceImageUpdateRequest $request): JsonResponse
    {
        $rentalSpaceImageRepository = new RentalSpaceImageRepository();
        $rentalSpaceGeneralRepository = new RentalSpaceGeneralRepository();
        $application = new RentalSpaceImageUpdatePutApplicationService(
            $rentalSpaceImageRepository,
            $rentalSpaceGeneralRepository
        );

        $command = new RentalSpaceImageUpdatePutCommand(
            $rentalSpaceId,
            $request['image_id'],
            $request['image_type'],
            $request['title']
        );

        $result = $application->handle($command);
        if (empty($result->imageId)) {
            return response()->json([
                'message' => "Update " . $request['image_type'] . "Fail !"
            ], 400);
        }

        return response()->json([
            'message' => 'Update successfully !',
            'image_id' => $result->imageId
        ], 200);
    }
}
