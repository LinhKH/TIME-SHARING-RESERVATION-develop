<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceNearTransportationRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\NearTransportationInformation;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\TransportationBundle\Domain\TransportationId;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class NearTransportationPostApplicationService
{

    /**
     * RentalSpaceGeneralRepository
     *
     * @var IRentalSpaceNearTransportationRepository
     */
    private IRentalSpaceNearTransportationRepository $nearTransportationRepository;


    /**
     * Construct
     */
    public function __construct(
        IRentalSpaceNearTransportationRepository $nearTransportationRepository
    )
    {
        $this->nearTransportationRepository = $nearTransportationRepository;
    }

    /**
     * @param NearTransportationPostCommand[] $commands
     * @return NearTransportationPostResult
     * @throws InvalidArgumentException
     * @throws TransactionException
     */
    public function handle(array $commands): NearTransportationPostResult
    {
        $nearTransportation = [];
        foreach ($commands as $command) {
            $nearTransportation[] = new NearTransportationInformation(
                new RentalSpaceId($command->rentalSpaceId),
                $command->transportationStationId ? new TransportationId($command->transportationStationId) : null,
                $command->walkingDuration,
                $command->ref,
                null,
                null,
                null
            );
        }

        DB::beginTransaction();
        try {
            $nearTransportationResponse = $this->nearTransportationRepository->createOrUpdateNearTransportation($nearTransportation);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw new TransactionException('更新できませんでした');
        }
        return new NearTransportationPostResult(
            $nearTransportationResponse ? $nearTransportationResponse->getValue() : null
        );
    }
}
