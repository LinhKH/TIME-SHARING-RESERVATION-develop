<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceImageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpace;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceDraftStep;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImage;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageType;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageValue;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpacePostImageApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceImageRepository
     */
    private IRentalSpaceImageRepository $rentalSpaceImageRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceImageRepository $rentalSpaceImageRepository
    )
    {
        $this->rentalSpaceImageRepository = $rentalSpaceImageRepository;
    }

    /**
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function handle(RentalSpacePostImageCommand $command): RentalSpacePostImageResult
    {
        $rentalSpaceImageValues = [];
        foreach ($command->imageFiles as $informationImage)
            $rentalSpaceImageValues[] = new RentalSpaceImageValue(
                RentalSpaceImageId::newId(),
                $informationImage['path_file'],
                $informationImage['title_image'] ?? null,
                RentalSpaceImageType::fromValue($informationImage['type']),
                $informationImage['width'],
                $informationImage['height'],
                $informationImage['length'],
                $informationImage['extension'],
                $informationImage['order_number']
            );
        $rentalSpaceImage = new RentalSpaceImage(
            new RentalSpaceId($command->rentalSpaceId),
            $rentalSpaceImageValues
        );
        $rentalSpace = new RentalSpace(
            new RentalSpaceId($command->rentalSpaceId),
            RentalSpaceDraftStep::fromType(RentalSpaceDraftStep::IMAGE),
            null,
            $rentalSpaceImage,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );
        DB::beginTransaction();
        try {
            $rentalSpaceResponse = $this->rentalSpaceImageRepository->createRentalSpaceImage($rentalSpace);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
        [$id,$draftStep] = $rentalSpaceResponse;
        return new RentalSpacePostImageResult(
            $id->getValue(),
            $draftStep->getValue()
        );
    }
}
