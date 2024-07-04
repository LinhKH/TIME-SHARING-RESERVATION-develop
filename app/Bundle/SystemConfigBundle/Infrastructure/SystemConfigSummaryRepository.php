<?php

namespace App\Bundle\SystemConfigBundle\Infrastructure;

use App\Bundle\Common\Constants\PaginationConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\Pagination;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageId;
use App\Bundle\SystemConfigBundle\Domain\Model\AreaId;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigSummaryRepository;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilation;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationId;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationImage;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationImageId;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationImageType;
use \App\Models\RentalSpaceCompilationImage as ModelRentalSpaceCompilationImage;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationInfomation;
use App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilationStatus;
use App\Models\RentalSpaceCompilation as ModelRentalSpaceCompilation;
use App\Models\RentalSpaceCompilationEav;
use App\Models\RentalSpaceCompilationEav as ModelRentalSpaceCompilationEav;
use DateTime;
use Exception;

class SystemConfigSummaryRepository implements ISystemConfigSummaryRepository
{
    public function getNextOrderNumber(): int
    {
        $rentalSpaceCompilationEntity = ModelRentalSpaceCompilation::orderBy('order_number', 'desc')->first();
        if (empty($rentalSpaceCompilationEntity)) {
            return 0;
        }
        return $rentalSpaceCompilationEntity->order_number + 1;
    }

    /**
     * @param RentalSpaceCompilation $rentalSpaceCompilation
     * @return RentalSpaceCompilationId
     * @throws InvalidArgumentException
     */
    public function createSystemConfigSummary(RentalSpaceCompilation $rentalSpaceCompilation): RentalSpaceCompilationId
    {
        $rentalSpaceCompilationEntity = ModelRentalSpaceCompilation::create([
            'access_key' => $rentalSpaceCompilation->getAccessKey(),
            'active' => $rentalSpaceCompilation->getIsActive()->getStatus(),
            'creation_time' => $rentalSpaceCompilation->getCreateTime()->format('U'),
            'modification_time' => $rentalSpaceCompilation->getModificationTime()->format('U'),
            'order_number' => $rentalSpaceCompilation->getOrderNumber(),
        ]);

        $rentalSpaceCompilationInfomation = $rentalSpaceCompilation->getRentalSpaceCompilationInfomation();

        ModelRentalSpaceCompilationEav::create([
            'attribute' => 'title__ja',
            'namespace' => $rentalSpaceCompilationEntity->id,
            'type' => 's',
            'value' => $rentalSpaceCompilationInfomation->getTitleJa()
        ]);

        ModelRentalSpaceCompilationEav::create([
            'attribute' => 'use_purpose_category',
            'namespace' => $rentalSpaceCompilationEntity->id,
            'type' => 's',
            'value' => $rentalSpaceCompilationInfomation->getUsePurposeCategory()
        ]);

        ModelRentalSpaceCompilationEav::create([
            'attribute' => 'subtitle__ja',
            'namespace' => $rentalSpaceCompilationEntity->id,
            'type' => 's',
            'value' => $rentalSpaceCompilationInfomation->getSubtitleJa()
        ]);

        if (!empty($rentalSpaceCompilationInfomation->getCatchJa())) {
            ModelRentalSpaceCompilationEav::create([
                'attribute' => 'catch__ja',
                'namespace' => $rentalSpaceCompilationEntity->id,
                'type' => 's',
                'value' => $rentalSpaceCompilationInfomation->getCatchJa()
            ]);
        }

        ModelRentalSpaceCompilationEav::create([
            'attribute' => 'summary__ja',
            'namespace' => $rentalSpaceCompilationEntity->id,
            'type' => 's',
            'value' => $rentalSpaceCompilationInfomation->getSummaryJa()
        ]);

        if (!empty($rentalSpaceCompilationInfomation->getAreaId())) {
            ModelRentalSpaceCompilationEav::create([
                'attribute' => 'area_id',
                'namespace' => $rentalSpaceCompilationEntity->id,
                'type' => 'i',
                'value' => $rentalSpaceCompilationInfomation->getAreaId()->getValue()
            ]);
        }

        if (!empty($rentalSpaceCompilationInfomation->getLastUpdate())) {
            ModelRentalSpaceCompilationEav::create([
                'attribute' => 'last_update',
                'namespace' => $rentalSpaceCompilationEntity->id,
                'type' => 's',
                'value' => $rentalSpaceCompilationInfomation->getLastUpdate()->format('Y-m-d')
            ]);
        }

        if (!empty($rentalSpaceCompilationInfomation->getMetaDescription())) {
            ModelRentalSpaceCompilationEav::create([
                'attribute' => 'meta_description',
                'namespace' => $rentalSpaceCompilationEntity->id,
                'type' => 's',
                'value' => $rentalSpaceCompilationInfomation->getMetaDescription()
            ]);
        }

        if (!empty($rentalSpaceCompilationInfomation->getMetaKeyword())) {
            ModelRentalSpaceCompilationEav::create([
                'attribute' => 'meta_keyword',
                'namespace' => $rentalSpaceCompilationEntity->id,
                'type' => 's',
                'value' => $rentalSpaceCompilationInfomation->getMetaKeyword()
            ]);
        }

        if (!empty($rentalSpaceCompilationInfomation->getRentalSpaceIds())) {
            foreach ($rentalSpaceCompilationInfomation->getRentalSpaceIds() as $key => $rentalSpaceId) {
                if ($rentalSpaceId) {
                    ModelRentalSpaceCompilationEav::create([
                        'attribute' => $key,
                        'namespace' => $rentalSpaceCompilationEntity->id,
                        'type' => 'i',
                        'value' => $rentalSpaceId
                    ]);
                }
            }
        }

        return new RentalSpaceCompilationId($rentalSpaceCompilationEntity->id);
    }

    /**
     * @return array{App\Bundle\Common\Domain\Model\Pagination, App\Bundle\SystemConfigBundle\Domain\Model\RentalSpaceCompilation[]}|null
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function findAll(): ?array
    {
        $result = ModelRentalSpaceCompilation::with(['RentalSpaceCompilationEav', 'rentalSpaceCompilationImage'])->paginate(PaginationConst::PAGINATE_ROW);
        if (empty($result)) {
            return null;
        }

        $entities = $result->toArray();
        $rentalSpaceCompilations = [];
        foreach ($entities['data'] as $entity) {
            $rentalSpaceCompilationInfomation = null;
            $rentalSpaceCompilationImages = [];
            if (!empty($entity['rental_space_compilation_eav'])) {
                $eavs = $entity['rental_space_compilation_eav'];
                $rentalSpaceIds = [];
                $attributes = [];
                foreach ($eavs as $eav) {
                    if (strpos($eav['attribute'], 'rental_space_ids__') !== false) {
                        $rentalSpaceIds[$eav['attribute']] = $eav['value'];
                    } else {
                        $attributes[$eav['attribute']] = $eav['value'];
                    }
                }
                $rentalSpaceCompilationInfomation = new RentalSpaceCompilationInfomation(
                    $attributes['title__ja'],
                    $attributes['use_purpose_category'],
                    $attributes['subtitle__ja'],
                    $attributes['catch__ja'] ?? null,
                    $attributes['summary__ja'],
                    isset($attributes['area_id']) ? new AreaId($attributes['area_id']) : null,
                    isset($attributes['last_update']) ? new DateTime($attributes['last_update']) : null,
                    $attributes['meta_keyword'] ?? null,
                    $attributes['meta_description'] ?? null,
                    $rentalSpaceIds
                );
            }

            if (!empty($entity['rental_space_compilation_image'])) {
                $rentalSpaceCompilationImageEntities = $entity['rental_space_compilation_image'];
                foreach ($rentalSpaceCompilationImageEntities as $rentalSpaceCompilationImageEntity) {
                    $rentalSpaceCompilationImages[] = new RentalSpaceCompilationImage(
                        new RentalSpaceCompilationImageId($rentalSpaceCompilationImageEntity['id']),
                        DateTime::createFromFormat('U', $rentalSpaceCompilationImageEntity['creation_time']),
                        $rentalSpaceCompilationImageEntity['name'],
                        RentalSpaceCompilationImageType::fromType($rentalSpaceCompilationImageEntity['type']),
                        $rentalSpaceCompilationImageEntity['width'],
                        $rentalSpaceCompilationImageEntity['height'],
                        $rentalSpaceCompilationImageEntity['length'],
                        $rentalSpaceCompilationImageEntity['extension'],
                        $rentalSpaceCompilationImageEntity['s3key'],
                        new RentalSpaceCompilationId($rentalSpaceCompilationImageEntity['parent_id'])
                    );
                }
            }

            $rentalSpaceCompilation = new RentalSpaceCompilation(
                new RentalSpaceCompilationId($entity['id']),
                $entity['access_key'],
                $entity['order_number'],
                RentalSpaceCompilationStatus::fromStatus($entity['active']),
                DateTime::createFromFormat('U', $entity['creation_time']),
                DateTime::createFromFormat('U', $entity['modification_time']),
                $rentalSpaceCompilationInfomation,
                $rentalSpaceCompilationImages
            );
            $rentalSpaceCompilations[] = $rentalSpaceCompilation;
        }

        $pagination = new Pagination(
            $result->lastPage(),
            $result->perPage(),
            $result->currentPage()
        );

        return [
            $pagination,
            $rentalSpaceCompilations
        ];
    }

    /**
     * @param RentalSpaceCompilationId $rentalSpaceCompilationId
     * @return RentalSpaceCompilation|null
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function findById(RentalSpaceCompilationId $rentalSpaceCompilationId): ?RentalSpaceCompilation
    {
        $entity = ModelRentalSpaceCompilation::with(['rentalSpaceCompilationEav', 'rentalSpaceCompilationImage'])->where('id', $rentalSpaceCompilationId->getValue())->first();
        if (empty($entity)) {
            return null;
        }

        $rentalSpaceCompilationInfomation = null;
        $rentalSpaceCompilationImages = [];
        if (!empty($entity->rentalSpaceCompilationEav)) {
            $eavs = $entity->rentalSpaceCompilationEav->toArray();
            $rentalSpaceIds = [];
            $attributes = [];
            foreach ($eavs as $eav) {
                if (strpos($eav['attribute'], 'rental_space_ids__') !== false) {
                    $rentalSpaceIds[$eav['attribute']] = $eav['value'];
                } else {
                    $attributes[$eav['attribute']] = $eav['value'];
                }
            }

            $rentalSpaceCompilationInfomation = new RentalSpaceCompilationInfomation(
                $attributes['title__ja'],
                $attributes['use_purpose_category'],
                $attributes['subtitle__ja'],
                $attributes['catch__ja'] ?? null,
                $attributes['summary__ja'],
                isset($attributes['area_id']) ? new AreaId($attributes['area_id']) : null,
                isset($attributes['last_update']) ? new DateTime($attributes['last_update']) : null,
                $attributes['meta_keyword'] ?? null,
                $attributes['meta_description'] ?? null,
                $rentalSpaceIds
            );
        }

        if (!empty($entity->rentalSpaceCompilationImage)) {
            $rentalSpaceCompilationImageEntities = $entity->rentalSpaceCompilationImage->toArray();
            foreach ($rentalSpaceCompilationImageEntities as $rentalSpaceCompilationImageEntity) {
                $rentalSpaceCompilationImages[] = new RentalSpaceCompilationImage(
                    new RentalSpaceCompilationImageId($rentalSpaceCompilationImageEntity['id']),
                    DateTime::createFromFormat('U', $rentalSpaceCompilationImageEntity['creation_time']),
                    $rentalSpaceCompilationImageEntity['name'],
                    RentalSpaceCompilationImageType::fromType($rentalSpaceCompilationImageEntity['type']),
                    $rentalSpaceCompilationImageEntity['width'],
                    $rentalSpaceCompilationImageEntity['height'],
                    $rentalSpaceCompilationImageEntity['length'],
                    $rentalSpaceCompilationImageEntity['extension'],
                    $rentalSpaceCompilationImageEntity['s3key'],
                    new RentalSpaceCompilationId($rentalSpaceCompilationImageEntity['parent_id'])
                );
            }
        }

        return new RentalSpaceCompilation(
            new RentalSpaceCompilationId($entity->id),
            $entity->access_key,
            $entity->order_number,
            RentalSpaceCompilationStatus::fromStatus($entity->active),
            DateTime::createFromFormat('U', $entity->creation_time),
            DateTime::createFromFormat('U', $entity->modification_time),
            $rentalSpaceCompilationInfomation,
            $rentalSpaceCompilationImages
        );
    }

    /**
     * @param RentalSpaceCompilationId $rentalSpaceCompilationId
     * @return bool
     */
    public function delete(RentalSpaceCompilationId $rentalSpaceCompilationId): bool
    {
        $rentalSpaceCompilationEntity = ModelRentalSpaceCompilation::find($rentalSpaceCompilationId->getValue());
        if ($rentalSpaceCompilationEntity) {
            $rentalSpaceCompilationEntity->delete();
            return true;
        }
        return false;
    }

    /**
     * @param RentalSpaceCompilation $rentalSpaceCompilation
     * @return RentalSpaceCompilationId|null
     * @throws InvalidArgumentException
     */
    public function updateSystemConfigSummary(RentalSpaceCompilation $rentalSpaceCompilation): ?RentalSpaceCompilationId
    {
        $rentalSpaceCompilationEntity = ModelRentalSpaceCompilation::findOrFail($rentalSpaceCompilation->getRentalSpaceCompilationId()->getValue());
        $rentalSpaceCompilationEntity->update([
            'access_key' => $rentalSpaceCompilation->getAccessKey(),
            'active' => $rentalSpaceCompilation->getIsActive()->getStatus(),
            'modification_time' => $rentalSpaceCompilation->getModificationTime()->format('U'),
        ]);
        RentalSpaceCompilationEav::where('namespace', $rentalSpaceCompilation->getRentalSpaceCompilationId()->getValue())->delete();

        $rentalSpaceCompilationInfomation = $rentalSpaceCompilation->getRentalSpaceCompilationInfomation();

        ModelRentalSpaceCompilationEav::create([
            'attribute' => 'title__ja',
            'namespace' => $rentalSpaceCompilationEntity->id,
            'type' => 's',
            'value' => $rentalSpaceCompilationInfomation->getTitleJa()
        ]);

        ModelRentalSpaceCompilationEav::create([
            'attribute' => 'use_purpose_category',
            'namespace' => $rentalSpaceCompilationEntity->id,
            'type' => 's',
            'value' => $rentalSpaceCompilationInfomation->getUsePurposeCategory()
        ]);

        ModelRentalSpaceCompilationEav::create([
            'attribute' => 'subtitle__ja',
            'namespace' => $rentalSpaceCompilationEntity->id,
            'type' => 's',
            'value' => $rentalSpaceCompilationInfomation->getSubtitleJa()
        ]);

        if (!empty($rentalSpaceCompilationInfomation->getCatchJa())) {
            ModelRentalSpaceCompilationEav::create([
                'attribute' => 'catch__ja',
                'namespace' => $rentalSpaceCompilationEntity->id,
                'type' => 's',
                'value' => $rentalSpaceCompilationInfomation->getCatchJa()
            ]);
        }

        ModelRentalSpaceCompilationEav::create([
            'attribute' => 'summary__ja',
            'namespace' => $rentalSpaceCompilationEntity->id,
            'type' => 's',
            'value' => $rentalSpaceCompilationInfomation->getSummaryJa()
        ]);

        if (!empty($rentalSpaceCompilationInfomation->getAreaId())) {
            ModelRentalSpaceCompilationEav::create([
                'attribute' => 'area_id',
                'namespace' => $rentalSpaceCompilationEntity->id,
                'type' => 'i',
                'value' => $rentalSpaceCompilationInfomation->getAreaId()->getValue()
            ]);
        }

        if (!empty($rentalSpaceCompilationInfomation->getLastUpdate())) {
            ModelRentalSpaceCompilationEav::create([
                'attribute' => 'last_update',
                'namespace' => $rentalSpaceCompilationEntity->id,
                'type' => 's',
                'value' => $rentalSpaceCompilationInfomation->getLastUpdate()->format('Y-m-d')
            ]);
        }

        if (!empty($rentalSpaceCompilationInfomation->getMetaDescription())) {
            ModelRentalSpaceCompilationEav::create([
                'attribute' => 'meta_description',
                'namespace' => $rentalSpaceCompilationEntity->id,
                'type' => 's',
                'value' => $rentalSpaceCompilationInfomation->getMetaDescription()
            ]);
        }

        if (!empty($rentalSpaceCompilationInfomation->getMetaKeyword())) {
            ModelRentalSpaceCompilationEav::create([
                'attribute' => 'meta_keyword',
                'namespace' => $rentalSpaceCompilationEntity->id,
                'type' => 's',
                'value' => $rentalSpaceCompilationInfomation->getMetaKeyword()
            ]);
        }

        if (!empty($rentalSpaceCompilationInfomation->getRentalSpaceIds())) {
            foreach ($rentalSpaceCompilationInfomation->getRentalSpaceIds() as $key => $rentalSpaceId) {
                ModelRentalSpaceCompilationEav::create([
                    'attribute' => $key,
                    'namespace' => $rentalSpaceCompilationEntity->id,
                    'type' => 'i',
                    'value' => $rentalSpaceId
                ]);
            }
        }
        return new RentalSpaceCompilationId(
            $rentalSpaceCompilationEntity->id
        );
    }

    /**
     * @param RentalSpaceCompilationId $rentalSpaceCompilationId
     * @param RentalSpaceCompilationImage $rentalSpaceCompilationImage
     * @return RentalSpaceCompilationImageId
     * @throws InvalidArgumentException
     */
    public function uploadImageSystemConfigSummary(RentalSpaceCompilationId $rentalSpaceCompilationId, RentalSpaceCompilationImage $rentalSpaceCompilationImage): RentalSpaceCompilationImageId
    {
        ModelRentalSpaceCompilation::findOrFail($rentalSpaceCompilationId->getValue());
        $rentalSpaceCompilationImageId = RentalSpaceCompilationImageId::newId();
        ModelRentalSpaceCompilationImage::create([
            'id' => $rentalSpaceCompilationImageId,
            'creation_time' => $rentalSpaceCompilationImage->getCreationTime()->format("U"),
            'extension' => $rentalSpaceCompilationImage->getExtension(),
            'height' => $rentalSpaceCompilationImage->getHeight(),
            'length' => $rentalSpaceCompilationImage->getLength(),
            'name' => $rentalSpaceCompilationImage->getName(),
            'parent_id' => $rentalSpaceCompilationImage->getParentId()->getValue(),
            's3key' => $rentalSpaceCompilationImage->getS3key(),
            'type' => $rentalSpaceCompilationImage->getType()->getType(),
            'width' => $rentalSpaceCompilationImage->getWidth()
        ]);
        return $rentalSpaceCompilationImageId;
    }

    /**
     * @param RentalSpaceCompilationImageId $rentalSpaceCompilationImageId
     * @return RentalSpaceCompilationImage|null
     * @throws Exception
     */
    public function findImageSystemSummaryById(RentalSpaceCompilationImageId $rentalSpaceCompilationImageId): ?RentalSpaceCompilationImage
    {
        $entity = ModelRentalSpaceCompilationImage::find($rentalSpaceCompilationImageId->asString());
        if (!$entity) {
            return null;
        }
        return new RentalSpaceCompilationImage(
            $rentalSpaceCompilationImageId,
            DateTime::createFromFormat('U', $entity->creation_time),
            $entity->name,
            RentalSpaceCompilationImageType::fromType($entity->type),
            $entity->width,
            $entity->height,
            $entity->length,
            $entity->extension,
            $entity->s3key,
            new RentalSpaceCompilationId($entity->parent_id)
        );
    }

    /**
     * @param RentalSpaceCompilationImageId $rentalSpaceCompilationImageId
     * @return bool|null
     */
    public function deleteImageSystemSummary(RentalSpaceCompilationImageId $rentalSpaceCompilationImageId): ?bool
    {
        $entity = ModelRentalSpaceCompilationImage::find($rentalSpaceCompilationImageId->asString());
        if ($entity) {
            $entity->delete();
            return true;
        }
        return false;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function updateImageSystemSummary(RentalSpaceCompilationImageId $rentalSpaceCompilationImageId, RentalSpaceCompilationImage $rentalSpaceCompilationImage): RentalSpaceCompilationImageId
    {
        $rentalSpaceCompilationImageEntity = ModelRentalSpaceCompilationImage::findOrFail($rentalSpaceCompilationImageId->asString());
        $rentalSpaceCompilationImageEntity->update([
            'type' => $rentalSpaceCompilationImage->getType()->getType()
        ]);
        return new RentalSpaceCompilationImageId(
            $rentalSpaceCompilationImageEntity->id
        );
    }
}

