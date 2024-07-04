<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceImageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageId;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceDeleteFacadeImageApplicationService
{
    /**
     * @var IRentalSpaceImageRepository
     */
    private IRentalSpaceImageRepository $rentalSpaceImageRepository;

    /**
     * RentalSpaceDeleteFacadeImageApplicationService constructor.
     * @param IRentalSpaceImageRepository $rentalSpaceImageRepository
     */
    public function __construct(IRentalSpaceImageRepository $rentalSpaceImageRepository)
    {
        $this->rentalSpaceImageRepository = $rentalSpaceImageRepository;
    }

    /**
     * @param RentalSpaceDeleteFacadeImageCommand $command
     * @return RentalSpaceDeleteFacadeImageResult
     * @throws TransactionException
     */
    public function handle(RentalSpaceDeleteFacadeImageCommand $command): RentalSpaceDeleteFacadeImageResult
    {
        $rentalSpaceImageId = new RentalSpaceImageId($command->imageId);
        DB::beginTransaction();
        try {
            $status = $this->rentalSpaceImageRepository->deleteFacadeImageById($rentalSpaceImageId);
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
        return new RentalSpaceDeleteFacadeImageResult(
            $message
        );
    }
}
