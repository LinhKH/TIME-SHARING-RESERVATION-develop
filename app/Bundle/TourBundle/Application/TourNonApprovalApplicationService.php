<?php

namespace App\Bundle\TourBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\TourBundle\Domain\Model\ChoiceDate;
use App\Bundle\TourBundle\Domain\Model\ITourRepository;
use App\Bundle\TourBundle\Domain\Model\NoReason;
use App\Bundle\TourBundle\Domain\Model\TourId;
use App\Bundle\TourBundle\Domain\Model\TourNonApproval;
use App\Bundle\TourBundle\Domain\Model\TourStatus;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class TourNonApprovalApplicationService
{
    /**
     * @var ITourRepository
     */
    private ITourRepository $tourRepository;

    /**
     * TourNonApprovalApplicationService constructor.
     * @param ITourRepository $tourRepository
     */
    public function __construct(
        ITourRepository $tourRepository
    ) {
        $this->tourRepository = $tourRepository;
    }

    /**
     * @param TourNonApprovalCommand $command
     * @return TourNonApprovalResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     * @throws TransactionException
     */
    public function handle(TourNonApprovalCommand $command): TourNonApprovalResult
    {
        $tour = $this->tourRepository->findById(new TourId($command->tourId));
        if (!$tour) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        $noReason = NoReason::fromNoReason($command->noReason);

        $tourNonApproval = new TourNonApproval(
            $tour->getTourId(),
            $noReason,
            new ChoiceDate(
                !empty($command->substitudeFirstChoiceDate) ? new \DateTime($command->substitudeFirstChoiceDate) : null,
                !empty($command->substitudeFirstChoiceTime) ? new \DateTime($command->substitudeFirstChoiceTime) : null,
            ),
            new ChoiceDate(
                !(empty($command->substitudeSecondChoiceDate)) ? new \DateTime($command->substitudeSecondChoiceDate) : null,
                !(empty($command->substitudeSecondChoiceTime)) ? new \DateTime($command->substitudeSecondChoiceTime) : null,
            ),
            new ChoiceDate(
                !(empty($command->substitudeThirdChoiceDate)) ? new \DateTime($command->substitudeThirdChoiceDate) : null,
                !(empty($command->substitudeThirdChoiceTime)) ? new \DateTime($command->substitudeThirdChoiceTime) : null,
            ),
            TourStatus::calcTourStatusByNoReason($noReason)
        );

        DB::beginTransaction();
        try {
            $tourId = $this->tourRepository->updateTourNonApproval($tourNonApproval);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new TourNonApprovalResult(
            $tourId->getValue()
        );
    }

}
