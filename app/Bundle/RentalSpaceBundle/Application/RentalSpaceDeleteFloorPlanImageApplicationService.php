<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceImageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageId;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceDeleteFloorPlanImageApplicationService
{
    private IRentalSpaceImageRepository $rentalSpaceImageRepository;

    /**
     * RentalSpaceDeleteFloorPlanImageApplicationService constructor.
     * @param IRentalSpaceImageRepository $rentalSpaceImageRepository
     */
    public function __construct(IRentalSpaceImageRepository $rentalSpaceImageRepository)
    {
        $this->rentalSpaceImageRepository = $rentalSpaceImageRepository;
    }

    /**
     * @param RentalSpaceDeleteFloorPlanImageCommand $command
     * @return RentalSpaceDeleteFloorPlanImageResult
     * @throws TransactionException
     */
    public function handle(RentalSpaceDeleteFloorPlanImageCommand $command): RentalSpaceDeleteFloorPlanImageResult
    {
        $rentalSpaceImageId = new RentalSpaceImageId($command->imageId);
        DB::beginTransaction();
        try {
            $status = $this->rentalSpaceImageRepository->deleteFloorPlanImageById($rentalSpaceImageId);
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
        return new RentalSpaceDeleteFloorPlanImageResult(
            $message
        );
    }
}
