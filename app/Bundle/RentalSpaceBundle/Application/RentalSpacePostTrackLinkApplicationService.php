<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceTrackLinkRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceTrackLink;
use App\Bundle\RentalSpaceBundle\Domain\Model\TrackLinkType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class RentalSpacePostTrackLinkApplicationService
{
    /**
     * Rental Space Track Link Repository
     *
     * @var IRentalSpaceTrackLinkRepository
     */
    private IRentalSpaceTrackLinkRepository $rentalSpaceTrackLinkRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceTrackLinkRepository $rentalSpaceTrackLinkRepository
    )
    {
        $this->rentalSpaceTrackLinkRepository = $rentalSpaceTrackLinkRepository;
    }

    /**
     * Rental Space Track Link
     * @param RentalSpacePostTrackLinkCommand $command
     * @return RentalSpacePostTrackLinkResult
     * @throws \App\Bundle\Common\Domain\Model\InvalidArgumentException
     * @throws TransactionException
     */
    public function handle(RentalSpacePostTrackLinkCommand $command): RentalSpacePostTrackLinkResult
    {
        $rentalSpaceTrackLink = new RentalSpaceTrackLink(
            new RentalSpaceId($command->rentalSpaceId),
            $command->name,
            TrackLinkType::fromType($command->type),
        );

        DB::beginTransaction();
        try {
            $rentalSpaceTrackLinkResponse = $this->rentalSpaceTrackLinkRepository->createRentalSpaceTrackLink($rentalSpaceTrackLink);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new RentalSpacePostTrackLinkResult(
            $rentalSpaceTrackLinkResponse->getRentalSpaceId()->getValue(),
            $rentalSpaceTrackLinkResponse->getName(),
            $rentalSpaceTrackLinkResponse->getType()->getValue()
        );
    }
}
