<?php
namespace App\Bundle\UserBundle\Application;

use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\UserBundle\Domain\Model\IOrganizationRepository;
use App\Bundle\UserBundle\Domain\Model\IUserRepository;
use App\Bundle\UserBundle\Domain\Model\UserId;
use App\Bundle\Common\Constants\MessageConst;

final class UserManageGetApplicationService
{
    /**
     * @var \App\Bundle\UserBundle\Domain\Model\IUserRepository
     */
    private IUserRepository $userRepository;

    /**
     * @var \App\Bundle\UserBundle\Domain\Model\IOrganizationRepository
     */
    private IOrganizationRepository $organizationRepository;

    /**
     * @param \App\Bundle\UserBundle\Domain\Model\IUserRepository $userRepository userRepository
     * @param \App\Bundle\UserBundle\Domain\Model\IOrganizationRepository $organizationRepository organizationRepository
     */
    public function __construct(
        IUserRepository $userRepository,
        IOrganizationRepository $organizationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * @param \App\Bundle\UserBundle\Application\UserManageGetCommand $command command
     * @return \App\Bundle\UserBundle\Application\UserManageGetResult
     */
    public function handle(UserManageGetCommand $command): UserManageGetResult
    {
        $user = $this->userRepository->findById(new UserId($command->userId));
        if (!$user) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $userRoles = [];
        $userWorkingGroups = [];
        foreach ($user->getUserRoles() as $userRole) {
            $userRoles[] = $userRole->getValue();
        }
        foreach ($user->getUserWorkingGroups() as $userWorkingGroup) {
            $userWorkingGroups[] = $userWorkingGroup->getValue();
        }

        return new UserManageGetResult(
            $user->getUserId()->getValue(),
            $user->getUserType()->getValue(),
            $user->getOrganizationId()->getValue(),
            $user->getOrganizationName(),
            $user->getIsActive(),
            $user->getEmail(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getFirstNameFurigana(),
            $user->getLastNameFurigana(),
            [],
            $user->getGenderType()->getValue(),
            $user->getRequestNotification(),
            $user->getReceiveEmail(),
            $userRoles,
            $userWorkingGroups,
            $user->getRegisterDate() ?? null,
            $user->getLoginLastDate() ?? null
        );
    }
}
