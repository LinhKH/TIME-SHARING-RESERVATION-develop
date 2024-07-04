<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageId;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceImageRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceDeleteImageApplicationService
{
    /**
     * @var RentalSpaceImageRepository
     */
    private RentalSpaceImageRepository $rentalSpaceImageRepository;

    /**
     * RentalSpaceDeleteImageApplicationService constructor.
     * @param RentalSpaceImageRepository $rentalSpaceImageRepository
     */
    public function __construct(RentalSpaceImageRepository $rentalSpaceImageRepository) {
        $this->rentalSpaceImageRepository = $rentalSpaceImageRepository;
    }

    /**
     * @param RentalSpaceDeleteImageCommand $command
     * @return RentalSpaceDeleteImageResult
     * @throws TransactionException
     */
    public function handle(RentalSpaceDeleteImageCommand $command): RentalSpaceDeleteImageResult
    {
        $rentalSpaceImageId = new RentalSpaceImageId($command->imageId);
        DB::beginTransaction();
        try {
            $status = $this->rentalSpaceImageRepository->deleteImageById($rentalSpaceImageId);
            DB::commit();
        } catch (Exception $e)
        {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('データがなし');
        }
        $message = 'Remove Image Successfully !';
        if (!$status) {
            $message = 'Remove Failed Image !';
        }
        return new RentalSpaceDeleteImageResult(
            $message
        );
    }
}
