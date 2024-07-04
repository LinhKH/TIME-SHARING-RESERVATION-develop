<?php


namespace App\Bundle\TourBundle\Application;


use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\TourBundle\Domain\Model\FixChoiceDate;
use App\Bundle\TourBundle\Domain\Model\ITourRepository;
use App\Bundle\TourBundle\Domain\Model\TourApproval;
use App\Bundle\TourBundle\Domain\Model\TourId;
use App\Bundle\TourBundle\Domain\Model\TourStatus;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class TourApprovalApplicationService
{
    /**
     * @var ITourRepository
     */
    private ITourRepository $tourRepository;

    /**
     * TourApprovalApplicationService constructor.
     * @param ITourRepository $tourRepository
     */
    public function __construct(
        ITourRepository $tourRepository
    )
    {
        $this->tourRepository = $tourRepository;
    }

    /**
     * @param TourApprovalCommand $command
     * @return TourApprovalResult
     * @throws InvalidArgumentException
     * @throws TransactionException
     */
    public function handle(TourApprovalCommand $command): TourApprovalResult
    {
        $tourApproval = new TourApproval(
            new TourId($command->tourId),
            TourStatus::fromStatus(TourStatus::WAIT_FOR_RESPONSE),
            FixChoiceDate::fromValue($command->tourDate)
        );


        DB::beginTransaction();
        try {
            $tourId = $this->tourRepository->updateTourApproval($tourApproval);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new TourApprovalResult(
            $tourId->getValue()
        );
    }
}
