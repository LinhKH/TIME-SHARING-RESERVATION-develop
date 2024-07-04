<?php

namespace App\Bundle\UserBundle\Application;

use App\Bundle\Common\Application\ITransaction;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\UserBundle\Domain\Model\GenderType;
use App\Bundle\UserBundle\Domain\Model\IUserRepository;
use App\Bundle\UserBundle\Domain\Model\OrganizationId;
use App\Bundle\UserBundle\Domain\Model\User;
use App\Bundle\UserBundle\Domain\Model\UserRole;
use App\Bundle\UserBundle\Domain\Model\UserType;
use App\Bundle\UserBundle\Domain\Model\UserWorkingGroup;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class UserManagePostApplicationService
{
    /**
     * @var IUserRepository
     */
    private IUserRepository $userRepository;

    /**
     * @param \App\Bundle\UserBundle\Domain\Model\IUserRepository $userRepository userRepository
     */
    public function __construct(
        IUserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param \App\Bundle\UserBundle\Application\UserManagePostCommand $command command
     * @return \App\Bundle\UserBundle\Application\UserManagePostResult
     */
    public function handle(UserManagePostCommand $command): UserManagePostResult
    {
        $userRoles = [];
        foreach ($command->userRoles as $userRole) {
            $userRoles[] = UserRole::fromValue($userRole);
        }
        $userWorkingGroups = [];
        foreach ($command->userWorkingGroups as $userWorkingGroup) {
            $userWorkingGroups[] = UserWorkingGroup::fromValue($userWorkingGroup);
        }
        $userManage = new User(
            null,
            new OrganizationId($command->organizationId),
            UserType::fromValue($command->userType),
            $command->active,
            $command->firstName,
            $command->lastName,
            $command->firstNameFurigana,
            $command->lastNameFurigana,
            [],
            GenderType::fromValue($command->gender),
            $command->email,
            $command->isRequestNotification,
            $command->isReceiveNewsletter,
            $userRoles,
            $userWorkingGroups,
            $command->password,
            null,
            null,
            $command->organizationName
        );

        DB::beginTransaction();
        try {
            $userId = $this->userRepository->createUser($userManage);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw new TransactionException('更新できませんでした');
        }

        return new UserManagePostResult(
            $userId->getValue()
        );
    }
}
