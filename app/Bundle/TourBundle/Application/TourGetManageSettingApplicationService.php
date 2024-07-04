<?php

namespace App\Bundle\TourBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceRepository;
use App\Bundle\TourBundle\Domain\Model\RentalSpaceResult;
use App\Bundle\UserBundle\Domain\Model\IUserRepository;
use App\Bundle\UserBundle\Domain\Model\UserId;
use Illuminate\Support\Facades\Auth;

final class TourGetManageSettingApplicationService
{
    private IRentalSpaceRepository $rentalSpaceRepository;
    private IUserRepository $userRepository;

    public function __construct(IRentalSpaceRepository $rentalSpaceRepository, IUserRepository $userRepository)
    {
        $this->rentalSpaceRepository = $rentalSpaceRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param TourGetManageSettingCommand $command
     * @return TourGetManageSettingResult|null
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(TourGetManageSettingCommand $command): ?TourGetManageSettingResult
    {
        $rentalSpaceResults = [];
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
            $rentalSpaceResults[] = new RentalSpaceResult(
                $rentalSpace->getRentalSpaceId()->getValue(),
                $rentalSpace->getTitle(),
                $rentalSpace->getTourFlg()
            );
        }
        return new TourGetManageSettingResult(
            $rentalSpaceResults
        );
    }
}
