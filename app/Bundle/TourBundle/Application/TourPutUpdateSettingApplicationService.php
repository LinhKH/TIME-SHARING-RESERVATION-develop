<?php

namespace App\Bundle\TourBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\DomainException;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\TourBundle\Domain\Model\ITourRepository;
use App\Bundle\UserBundle\Domain\Model\IUserRepository;
use App\Bundle\UserBundle\Domain\Model\UserId;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class TourPutUpdateSettingApplicationService
{
    private ITourRepository $tourRepository;

    private IRentalSpaceRepository $rentalSpaceRepository;

    private IUserRepository $userRepository;

    /**
     * TourPutUpdateSettingApplicationService constructor.
     * @param ITourRepository $tourRepository
     * @param IRentalSpaceRepository $rentalSpaceRepository
     * @param IUserRepository $userRepository
     */
    public function __construct(ITourRepository $tourRepository, IRentalSpaceRepository $rentalSpaceRepository, IUserRepository $userRepository)
    {
        $this->tourRepository = $tourRepository;
        $this->rentalSpaceRepository = $rentalSpaceRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws InvalidArgumentException|RecordNotFoundException
     * @throws TransactionException
     */
    public function handle(TourPutUpdateSettingCommand $command)
    {
        $rentalSpaceUpdate = [];
        $rentalSpaceInOrganization = [];
        $organizationId = null;
        $flag = false;
        if ($command->organizationId) {
            $organizationId = new OrganizationId($command->organizationId);
        } else {
            $userId = new UserId(Auth::id());
            $user = $this->userRepository->findById($userId);
            $organizationId = new OrganizationId($user->getOrganizationId()->getValue());
        }
        if (!$organizationId) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $rentalSpaces = $this->rentalSpaceRepository->getListIdByOrganizationId($organizationId);
        if (!$rentalSpaces) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        foreach ($rentalSpaces as $rentalSpace) {
            $rentalSpaceInOrganization[] = $rentalSpace->getRentalSpaceId();
        }
        foreach (json_decode($command->rentalSpaceIds) as $rentalSpaceId) {
            $rentalSpaceUpdate[] = new RentalSpaceId($rentalSpaceId);
        }
        DB::beginTransaction();
        try {
            $flag = $this->rentalSpaceRepository->updateTourSetting($rentalSpaceUpdate, $rentalSpaceInOrganization);
            DB::commit();
        } catch (Exception $exception)
        {
            DB::rollBack();
            Log::error($exception);
            throw new TransactionException('更新できませんでした');
        }
        return new TourPutUpdateSettingResult(
            $flag
        );
    }
}
