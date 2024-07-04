<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Domain\Model\DomainException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceImageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceImageId;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpaceDeletePanoramaImageApplicationService
{
    /**
     * @var IRentalSpaceImageRepository
     */
    private IRentalSpaceImageRepository $rentalSpaceImageRepository;

    /**
     * RentalSpaceDeletePanoramaImageApplicationService constructor.
     * @param IRentalSpaceImageRepository $rentalSpaceImageRepository
     */
    public function __construct(IRentalSpaceImageRepository $rentalSpaceImageRepository)
    {
        $this->rentalSpaceImageRepository = $rentalSpaceImageRepository;
    }

    /**
     * @param RentalSpaceDeletePanoramaImageCommand $command
     * @return RentalSpaceDeletePanoramaImageResult
     * @throws TransactionException
     */
    public function handle(RentalSpaceDeletePanoramaImageCommand $command): RentalSpaceDeletePanoramaImageResult
    {
        $rentalSpaceImageId = new RentalSpaceImageId($command->imageId);
        DB::beginTransaction();
        try {
            $status = $this->rentalSpaceImageRepository->deletePanoramaImageById($rentalSpaceImageId);
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
        return new RentalSpaceDeletePanoramaImageResult(
            $message
        );
    }
}
