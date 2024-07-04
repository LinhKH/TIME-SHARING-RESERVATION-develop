<?php

namespace App\Bundle\RentalSpaceBundle\Infrastructure;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceImageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImage;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageValue;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageTitleEav;
use App\Models\RentalSpace as ModelRentalSpace;
use App\Models\RentalSpaceDirectionsStationImage as ModelRentalSpaceDirectionsStationImage;
use App\Models\RentalSpaceDirectionsStationImageEav as ModelRentalSpaceDirectionsStationImageEav;
use App\Models\RentalSpaceFacadeImage as ModelRentalSpaceFacadeImage;
use App\Models\RentalSpaceFacadeImageEav as ModelRentalSpaceFacadeImageEav;
use App\Models\RentalSpaceFloorPlan as ModelRentalSpaceFloorPlan;
use App\Models\RentalSpaceFloorPlanEav as ModelRentalSpaceFloorPlanEav;
use App\Models\RentalSpaceImage as ModelRentalSpaceImage;
use App\Models\RentalSpaceImageEav as ModelRentalSpaceImageEav;
use App\Models\RentalSpacePanoramaImage as ModelRentalSpacePanoramaImage;
use App\Models\RentalSpacePanoramaImageEav as ModelRentalSpacePanoramaImageEav;
use Illuminate\Support\Facades\Storage;

class RentalSpaceImageRepository implements IRentalSpaceImageRepository
{
    /**
     * Create image for space
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     * @throws InvalidArgumentException
     */
    public function createRentalSpaceImage(RentalSpace $rentalSpace): array
    {
        $dataImages = $rentalSpace->getRentalSpaceImage()->getImageFiles();
        foreach ($dataImages as $dataImage) {
            if ($dataImage->getType()->getType() === RentalSpaceImageType::IMAGE) {
                ModelRentalSpaceImage::create([
                    'id' => $dataImage->getImageId(),
                    'height' => $dataImage->getHeight(),
                    'extension' => $dataImage->getExtension(),
                    'length' => $dataImage->getLength(),
                    'order_number' => $dataImage->getOrderNumber(),
                    'parent_id' => $rentalSpace->getRentalSpaceId()->getValue(),
                    'width' => $dataImage->getWidth(),
                    's3key' => $dataImage->getPathImage(),
                    'creation_time' => time()
                ]);
                if (!empty($dataImage->getTitleImage())) {
                    ModelRentalSpaceImageEav::create([
                        'namespace' => $dataImage->getImageId(),
                        'attribute' => 'title__ja',
                        'value' => $dataImage->getTitleImage(),
                        'type' => 's'
                    ]);
                }
            }
            if ($dataImage->getType()->getType() === RentalSpaceImageType::IMAGE_PANORAMA) {
                ModelRentalSpacePanoramaImage::create([
                    'id' => $dataImage->getImageId(),
                    'height' => $dataImage->getHeight(),
                    'extension' => $dataImage->getExtension(),
                    'length' => $dataImage->getLength(),
                    'order_number' => $dataImage->getOrderNumber(),
                    'parent_id' => $rentalSpace->getRentalSpaceId()->getValue(),
                    'width' => $dataImage->getWidth(),
                    's3key' => $dataImage->getPathImage(),
                    'creation_time' => time()
                ]);
                if (!empty($dataImage->getTitleImage())) {
                    ModelRentalSpacePanoramaImageEav::create([
                        'namespace' => $dataImage->getImageId(),
                        'attribute' => 'title__ja',
                        'value' => $dataImage->getTitleImage(),
                        'type' => 's'
                    ]);
                }
            }
            if ($dataImage->getType()->getType() === RentalSpaceImageType::IMAGE_FACADE) {
                ModelRentalSpaceFacadeImage::create([
                    'id' => $dataImage->getImageId(),
                    'height' => $dataImage->getHeight(),
                    'extension' => $dataImage->getExtension(),
                    'length' => $dataImage->getLength(),
                    'order_number' => $dataImage->getOrderNumber(),
                    'parent_id' => $rentalSpace->getRentalSpaceId()->getValue(),
                    'width' => $dataImage->getWidth(),
                    's3key' => $dataImage->getPathImage(),
                    'creation_time' => time()
                ]);

                if (!empty($dataImage->getTitleImage())) {
                    ModelRentalSpaceFacadeImageEav::create([
                        'namespace' => $dataImage->getImageId(),
                        'attribute' => 'title__ja',
                        'value' => $dataImage->getTitleImage(),
                        'type' => 's'
                    ]);
                }
            }
            if ($dataImage->getType()->getType() === RentalSpaceImageType::IMAGE_DIRECTION_STATION) {

                ModelRentalSpaceDirectionsStationImage::create([
                    'id' => $dataImage->getImageId(),
                    'height' => $dataImage->getHeight(),
                    'extension' => $dataImage->getExtension(),
                    'length' => $dataImage->getLength(),
                    'order_number' => $dataImage->getOrderNumber(),
                    'parent_id' => $rentalSpace->getRentalSpaceId()->getValue(),
                    'width' => $dataImage->getWidth(),
                    's3key' => $dataImage->getPathImage(),
                    'creation_time' => time()
                ]);

                if (!empty($dataImage->getTitleImage())) {
                    ModelRentalSpaceDirectionsStationImageEav::create([
                        'namespace' => $dataImage->getImageId(),
                        'attribute' => 'title__ja',
                        'value' => $dataImage->getTitleImage(),
                        'type' => 's'
                    ]);
                }
            }
            if ($dataImage->getType()->getType() === RentalSpaceImageType::IMAGE_FLOOR_PLAN) {
                ModelRentalSpaceFloorPlan::create([
                    'id' => $dataImage->getImageId(),
                    'height' => $dataImage->getHeight(),
                    'extension' => $dataImage->getExtension(),
                    'length' => $dataImage->getLength(),
                    'order_number' => $dataImage->getOrderNumber(),
                    'parent_id' => $rentalSpace->getRentalSpaceId()->getValue(),
                    'width' => $dataImage->getWidth(),
                    's3key' => $dataImage->getPathImage(),
                    'creation_time' => time()
                ]);

                if (!empty($dataImage->getTitleImage())) {
                    ModelRentalSpaceFloorPlanEav::create([
                        'namespace' => $dataImage->getImageId(),
                        'attribute' => 'title__ja',
                        'value' => $dataImage->getTitleImage(),
                        'type' => 's'
                    ]);
                }
            }
        }
        $rentalSpaceModel = ModelRentalSpace::findOrFail($rentalSpace->getRentalSpaceId()->getValue());
        $rentalSpaceModel->update([
            'draft_step' => $rentalSpace->getDraftStep()->nextStep()
        ]);
        $rentalSpaceModel->save();
        return [new RentalSpaceId($rentalSpaceModel->id), new RentalSpaceDraftStep($rentalSpaceModel->draft_step)];
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceImage|null
     * @throws InvalidArgumentException
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?RentalSpaceImage
    {
        $entitiesImage = ModelRentalSpaceImage::where('parent_id', $rentalSpaceId->getValue())->with('rentalSpaceImageEav')->get();
        if (empty($entitiesImage)) {
            return null;
        }
        $resultImage = [];

        foreach ($entitiesImage as $entity) {
            $rentalSpaceImageEav = $entity->rentalSpaceImageEav->first();
            $resultImage[] = new RentalSpaceImageValue(
                $entity->id,
                $entity->s3key,
                $rentalSpaceImageEav->value ?? null,
                RentalSpaceImageType::fromType(RentalSpaceImageType::IMAGE),
                $entity->width,
                $entity->height,
                $entity->length,
                $entity->extension,
                $entity->order_number,
            );
        }

        return new RentalSpaceImage(
            $rentalSpaceId,
            $resultImage
        );
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceImage|null
     * @throws InvalidArgumentException
     */
    public function findAllPanoramaImageById(RentalSpaceId $rentalSpaceId): ?RentalSpaceImage
    {
        $entitiesImagePanorama = ModelRentalSpacePanoramaImage::where('parent_id', $rentalSpaceId->getValue())->with('panoramaImageEav')->get();
        if (!$entitiesImagePanorama) {
            return null;
        }
        $resultImage = [];
        foreach ($entitiesImagePanorama as $entity) {
            $panoramaImageEav = $entity->panoramaImageEav->first();
            $resultImage[] = new RentalSpaceImageValue(
                $entity->id,
                $entity->s3key,
                $panoramaImageEav->value ?? null,
                RentalSpaceImageType::fromType(RentalSpaceImageType::IMAGE_PANORAMA),
                $entity->width,
                $entity->height,
                $entity->length,
                $entity->extension,
                $entity->order_number,
            );
        }
        return new RentalSpaceImage(
            $rentalSpaceId,
            $resultImage
        );
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceImage|null
     * @throws InvalidArgumentException
     */
    public function findAllFacadeImageById(RentalSpaceId $rentalSpaceId): ?RentalSpaceImage
    {
        $entitiesImageFacade = ModelRentalSpaceFacadeImage::where('parent_id', $rentalSpaceId->getValue())->with('rentalSpaceFacadeImageEav')->get();
        if (!$entitiesImageFacade) {
            return null;
        }
        $resultImage = [];
        foreach ($entitiesImageFacade as $entity) {
            $facadeImageEav = $entity->rentalSpaceFacadeImageEav->first();
            $resultImage[] = new RentalSpaceImageValue(
                $entity->id,
                $entity->s3key,
                $facadeImageEav->value ?? null,
                RentalSpaceImageType::fromType(RentalSpaceImageType::IMAGE_FACADE),
                $entity->width,
                $entity->height,
                $entity->length,
                $entity->extension,
                $entity->order_number,
            );
        }
        return new RentalSpaceImage(
            $rentalSpaceId,
            $resultImage
        );
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceImage|null
     * @throws InvalidArgumentException
     */
    public function findAllDirectionStationImageById(RentalSpaceId $rentalSpaceId): ?RentalSpaceImage
    {
        $entitiesImageDirectionStation = ModelRentalSpaceDirectionsStationImage::where('parent_id', $rentalSpaceId->getValue())->with('rentalSpaceDirectionsStationImageEav')->get();
        if (!$entitiesImageDirectionStation) {
            return null;
        }
        $resultImage = [];

        foreach ($entitiesImageDirectionStation as $entity) {
            $directionsStationImageEav = $entity->rentalSpaceDirectionsStationImageEav->first();
            $resultImage[] = new RentalSpaceImageValue(
                $entity->id,
                $entity->s3key,
                $directionsStationImageEav->value ?? null,
                RentalSpaceImageType::fromType(RentalSpaceImageType::IMAGE_DIRECTION_STATION),
                $entity->width,
                $entity->height,
                $entity->length,
                $entity->extension,
                $entity->order_number,
            );
        }
        return new RentalSpaceImage(
            $rentalSpaceId,
            $resultImage
        );
    }

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceImage|null
     * @throws InvalidArgumentException
     */
    public function findAllFloorPlanImageById(RentalSpaceId $rentalSpaceId): ?RentalSpaceImage
    {
        $entitiesImageFloorPlan = ModelRentalSpaceFloorPlan::where('parent_id', $rentalSpaceId->getValue())->with('rentalSpaceFloorPlanEav')->get();
        if (!$entitiesImageFloorPlan) {
            return null;
        }
        $resultImage = [];

        foreach ($entitiesImageFloorPlan as $entity) {
            $floorPlanEav = $entity->rentalSpaceFloorPlanEav->first();
            $resultImage[] = new RentalSpaceImageValue(
                $entity->id,
                $entity->s3key,
                $floorPlanEav->value ?? null,
                RentalSpaceImageType::fromType(RentalSpaceImageType::IMAGE_FLOOR_PLAN),
                $entity->width,
                $entity->height,
                $entity->length,
                $entity->extension,
                $entity->order_number,
            );
        }
        return new RentalSpaceImage(
            $rentalSpaceId,
            $resultImage
        );
    }

    /**
     * @param RentalSpaceImageId $rentalSpaceImageId
     * @return bool
     */
    public function deleteImageById(RentalSpaceImageId $rentalSpaceImageId): bool
    {
        $entityImage = ModelRentalSpaceImage::findOrFail($rentalSpaceImageId->asString());
        if (Storage::exists($entityImage->s3key)) {
            $entityImage->delete();
            Storage::delete($entityImage->s3key);
        } else {
            return false;
        }
        return true;
    }

    /**
     * @param RentalSpaceImageId $rentalSpaceImageId
     * @return bool
     */
    public function deletePanoramaImageById(RentalSpaceImageId $rentalSpaceImageId): bool
    {
        $entityImage = ModelRentalSpacePanoramaImage::findOrFail($rentalSpaceImageId->asString());
        if (Storage::exists($entityImage->s3key)) {
            $entityImage->delete();
            Storage::delete($entityImage->s3key);
        } else {
            return false;
        }
        return true;
    }

    /**
     * @param RentalSpaceImageId $rentalSpaceImageId
     * @return bool
     */
    public function deleteFacadeImageById(RentalSpaceImageId $rentalSpaceImageId): bool
    {
        $entityImage = ModelRentalSpaceFacadeImage::findOrFail($rentalSpaceImageId->asString());
        if (Storage::exists($entityImage->s3key)) {
            $entityImage->delete();
            Storage::delete($entityImage->s3key);
        } else {
            return false;
        }
        return true;
    }

    /**
     * @param RentalSpaceImageId $rentalSpaceImageId
     * @return bool
     */
    public function deleteDirectionStationImageById(RentalSpaceImageId $rentalSpaceImageId): bool
    {
        $entityImage = ModelRentalSpaceDirectionsStationImage::findOrFail($rentalSpaceImageId->asString());
        if (Storage::exists($entityImage->s3key)) {
            $entityImage->delete();
            Storage::delete($entityImage->s3key);
        } else {
            return false;
        }
        return true;
    }

    /**
     * @param RentalSpaceImageId $rentalSpaceImageId
     * @return bool
     */
    public function deleteFloorPlanImageById(RentalSpaceImageId $rentalSpaceImageId): bool
    {
        $entityImage = ModelRentalSpaceFloorPlan::findOrFail($rentalSpaceImageId->asString());
        if (Storage::exists($entityImage->s3key)) {
            $entityImage->delete();
            Storage::delete($entityImage->s3key);
        } else {
            return false;
        }
        return true;
    }


    /**
     * update Title Image With Type
     * @param RentalSpaceImageTitleEav $rentalSpaceImageTitleEav
     * @return RentalSpaceImageId|null
     */
    public function updateTitleImageWithType(RentalSpaceImageTitleEav $rentalSpaceImageTitleEav): ?RentalSpaceImageId
    {
        // TODO: Implement updateTitleImageWithType() method.
        if ($rentalSpaceImageTitleEav->getImageType()->getType() === RentalSpaceImageType::IMAGE) {
            $image = ModelRentalSpaceImage::find($rentalSpaceImageTitleEav->getImageId()->asString());
            if (empty($image)) {
                return null;
            }
            $imageEav = ModelRentalSpaceImageEav::where('namespace', $rentalSpaceImageTitleEav->getImageId()->asString())->first();
            if (!empty($imageEav)) {
                $imageEav->delete();
            }
            ModelRentalSpaceImageEav::create([
                'namespace' => $rentalSpaceImageTitleEav->getImageId()->asString(),
                'attribute' => 'title__ja',
                'value' => $rentalSpaceImageTitleEav->getTitle(),
                'type' => 's'
            ]);
        }
        if ($rentalSpaceImageTitleEav->getImageType()->getType() === RentalSpaceImageType::IMAGE_PANORAMA) {
            $image = ModelRentalSpacePanoramaImage::find($rentalSpaceImageTitleEav->getImageId()->asString());
            if (empty($image)) {
                return null;
            }
            $imagePanoramaEav = ModelRentalSpacePanoramaImageEav::where('namespace', $rentalSpaceImageTitleEav->getImageId()->asString())->first();
            if (!empty($imagePanoramaEav)) {
                $imagePanoramaEav->delete();
            }
            ModelRentalSpacePanoramaImageEav::create([
                'namespace' => $rentalSpaceImageTitleEav->getImageId()->asString(),
                'attribute' => 'title__ja',
                'value' => $rentalSpaceImageTitleEav->getTitle(),
                'type' => 's'
            ]);
        }
        if ($rentalSpaceImageTitleEav->getImageType()->getType() === RentalSpaceImageType::IMAGE_FACADE) {
            $image = ModelRentalSpaceFacadeImage::find($rentalSpaceImageTitleEav->getImageId()->asString());
            if (empty($image)) {
                return null;
            }
            $imageFacadeEav = ModelRentalSpaceFacadeImageEav::where('namespace', $rentalSpaceImageTitleEav->getImageId()->asString())->first();
            $imageFacadeEav->delete();
            if (!empty($imageFacadeEav)) {
                $imageFacadeEav->delete();
            }
            ModelRentalSpaceFacadeImageEav::create([
                'namespace' => $rentalSpaceImageTitleEav->getImageId()->asString(),
                'attribute' => 'title__ja',
                'value' => $rentalSpaceImageTitleEav->getTitle(),
                'type' => 's'
            ]);
        }
        if ($rentalSpaceImageTitleEav->getImageType()->getType() === RentalSpaceImageType::IMAGE_DIRECTION_STATION) {
            $image = ModelRentalSpaceDirectionsStationImage::find($rentalSpaceImageTitleEav->getImageId()->asString());
            if (empty($image)) {
                return null;
            }
            $imageDirectionsStationEav = ModelRentalSpaceDirectionsStationImageEav::where('namespace', $rentalSpaceImageTitleEav->getImageId()->asString())->first();
            if (!empty($imageDirectionsStationEav)) {
                $imageDirectionsStationEav->delete();
            }
            ModelRentalSpaceDirectionsStationImageEav::create([
                'namespace' => $rentalSpaceImageTitleEav->getImageId()->asString(),
                'attribute' => 'title__ja',
                'value' => $rentalSpaceImageTitleEav->getTitle(),
                'type' => 's'
            ]);
        }
        if ($rentalSpaceImageTitleEav->getImageType()->getType() === RentalSpaceImageType::IMAGE_FLOOR_PLAN) {
            $image = ModelRentalSpaceFloorPlan::find($rentalSpaceImageTitleEav->getImageId()->asString());
            if (empty($image)) {
                return null;
            }
            $imageFloorPlanEav = ModelRentalSpaceFloorPlanEav::where('namespace', $rentalSpaceImageTitleEav->getImageId()->asString())->first();
            if (!empty($imageFloorPlanEav)) {
                $imageFloorPlanEav->delete();
            }
            ModelRentalSpaceFloorPlanEav::create([
                'namespace' => $rentalSpaceImageTitleEav->getImageId()->asString(),
                'attribute' => 'title__ja',
                'value' => $rentalSpaceImageTitleEav->getTitle(),
                'type' => 's'
            ]);
        }
        return $rentalSpaceImageTitleEav->getImageId();
    }

    public function deleteAllImage($rentalSpaceId)
    {
        $sql = ModelRentalSpaceImage::where('parent_id', $rentalSpaceId)->get();

        if (!empty($sql->toArray())) {
            return $sql->each->delete();
        }
    }
}
