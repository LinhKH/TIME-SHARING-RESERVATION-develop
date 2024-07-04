<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceGeneralRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceImageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageTitleEav;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageType;
use Exception;
use http\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceImageUpdatePutApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceImageRepository
     */
    private IRentalSpaceImageRepository $rentalSpaceImageRepository;

    /**
     * @var IRentalSpaceGeneralRepository
     */
    private IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceImageRepository $rentalSpaceImageRepository,
        IRentalSpaceGeneralRepository $rentalSpaceGeneralRepository
    ) {
        $this->rentalSpaceGeneralRepository = $rentalSpaceGeneralRepository;
        $this->rentalSpaceImageRepository = $rentalSpaceImageRepository;
    }

    /**
     * @throws TransactionException
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceImageUpdatePutCommand $command): RentalSpaceImageUpdatePutResult
    {
        $rentalSpace = $this->rentalSpaceGeneralRepository->findById(new RentalSpaceId($command->rentalSpaceId));
        if (empty($rentalSpace)) {
            throw new RecordNotFoundException($command->rentalSpaceId . MessageConst::NOT_FOUND['message']);
        }

        $rentalSpaceImage = new RentalSpaceImageTitleEav(
            new RentalSpaceId($command->rentalSpaceId),
            new RentalSpaceImageId($command->imageId),
            RentalSpaceImageType::fromValue($command->imageType),
            $command->title
        );

        DB::beginTransaction();
        try {
            $rentalSpaceImage = $this->rentalSpaceImageRepository->updateTitleImageWithType($rentalSpaceImage);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new RentalSpaceImageUpdatePutResult(
            $rentalSpaceImage ?? $rentalSpaceImage->asString()
        );
    }
}
