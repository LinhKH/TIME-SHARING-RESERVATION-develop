<?php

namespace App\Bundle\UserBundle\Infrastructure;

use App\Bundle\Common\Constants\DateTimeConst;
use App\Bundle\Common\Constants\PaginationConst;
use App\Bundle\UserBundle\Domain\Model\GenderType;
use App\Bundle\UserBundle\Domain\Model\IUserRepository;
use App\Bundle\UserBundle\Domain\Model\OrganizationId;
use App\Bundle\UserBundle\Domain\Model\Pagination;
use App\Bundle\UserBundle\Domain\Model\User;
use App\Bundle\UserBundle\Domain\Model\UserId;
use App\Bundle\UserBundle\Domain\Model\UserRole;
use App\Bundle\UserBundle\Domain\Model\UserType;
use App\Bundle\UserBundle\Domain\Model\UserWorkingGroup;
use App\Models\User as ModelUser;
use App\Models\Reservation as ModelReservation;
use App\Models\RentalSpaceEav as ModelRentalSpaceEav;
use App\Services\CommonConstant;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserRepository implements IUserRepository
{
    /**
     * @inheritDoc
     */
    public function createUser(User $user): UserId
    {
        $result = ModelUser::create([
            'active' => $user->getIsActive(),
            'creation_time' => time(),
            'email' => $user->getEmail(),
            'email_verified_at' => null,
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'first_name_furigana' => $user->getFirstNameFurigana(),
            'last_name_furigana' => $user->getLastNameFurigana(),
            'password' => $user->getPassword(),
            'gender' => $user->getGenderType()->getValue(),
            'last_login_time' => time(),
            'locale_key_spoken' => null,
            'receive_space_search_form_notification' => $user->getRequestNotification(),
            'subscribe_mail_magazine' => $user->getReceiveEmail(),
            'organization_id' => $user->getOrganizationId()->getValue(),
            'roles' => $user->getUserRoleWithJson(),
            'working_groups' => $user->getUserWorkingGroupsWithJson(),
            'type' => $user->getUserType()->getValue(),
            'remember_token' => null,
            'locale_key' => 'ja',
            'login_count_current_month' => null,
            'login_trigger' => 0,
            'recovery_token' => null,
            'organization_name' => $user->getOrganizationName()
        ]);

        return new UserId($result->id);
    }

    /**
     * @inheritDoc
     */
    public function remove(UserId $userId): bool
    {
        // TO DO
        return true;
    }

    /**
     * @inheritDoc
     */
    public function findById(UserId $userId): ?User
    {
        $entity = ModelUser::find($userId->getValue());
        if (!$entity) {
            return null;
        }
        $userRoles = [];
        foreach (json_decode($entity->roles) as $userRole) {
            $userRoles[] = UserRole::fromValue($userRole);
        }
        $userWorkingGroups = [];
        foreach (json_decode($entity->working_groups) as $userWorkingGroup) {
            $userWorkingGroups[] = UserWorkingGroup::fromValue($userWorkingGroup);
        }

        $users = new User(
            new UserId($entity->id),
            new OrganizationId($entity->organization_id ?? 1),
            UserType::fromValue($entity->type ?? 1),
            (bool)$entity->active,
            $entity->first_name,
            $entity->last_name,
            $entity->first_name_furigana,
            $entity->last_name_furigana,
            [],
            GenderType::fromValue($entity->gender ?? 1),
            $entity->email,
            (bool)$entity->receive_space_search_form_notification,
            (bool)$entity->subscribe_mail_magazine,
            $userRoles,
            $userWorkingGroups,
            $entity->password,
            date(DateTimeConst::FORMAT, $entity->creation_time),
            $entity->last_login_time ? date(DateTimeConst::FORMAT, $entity->last_login_time) : null,
            $entity->organization_name
        );

        return $users;
    }

    /**
     * @inheritDoc
     */
    public function findAll($search = null): array
    {

        if (!empty($search['created_at'])) {
            $entities =  ModelUser::orderBy('created_at', $search['created_at']);
        } else {
            $entities = ModelUser::orderBy('id', 'DESC');
        }

        if (!empty($search['name'])) {
            $entities->where('first_name', 'like', "%{$search['name']}%");
        }

        if (!empty($search['email'])) {
            $entities->where('email', 'like', "%{$search['email']}%");
        }

        if (isset($search['organization_name'])) {
            $entities->where('organization_name', 'like', "%{$search['organization_name']}%");
        }

        if (!empty($search['type'])) {
            $entities->where('type', $search['type']);
        }

        // 0:deactive, 1:active
        if (isset($search['active'])) {
            $entities->where('active', $search['active']);
        }

        // 0:deactive, 1:active
        if (isset($search['subscribe_mail_magazine'])) {
            $entities->where('subscribe_mail_magazine', $search['subscribe_mail_magazine']);
        }

        if (!empty($search['start_date']) && !empty($search['end_date'])) {
            $entities->whereDate('created_at', '>=', $search['start_date'])->whereDate('created_at', '<=', $search['end_date']);
        }

        $entities = $entities->paginate(PaginationConst::PAGINATE_ROW);

        $users = [];
        foreach ($entities as $entity) {
            $userRoles = [];

            if(is_array($entity->roles) && !empty($entity->roles)) {
                foreach ($entity->roles as $role) {
                    $userRoles[] = UserRole::fromValue($role);
                }
            }
            // foreach (json_decode($entity->roles) as $userRole) {
            //     $userRoles[] = UserRole::fromValue($userRole);
            // }
            $userWorkingGroups = [];
            if (is_array($entity->working_groups) && !empty($entity->working_groups)) {
                foreach ($entity->working_groups as $role) {
                    $userWorkingGroups[] = UserWorkingGroup::fromValue($role);
                }
            }
            // foreach (json_decode($entity->working_groups) as $userWorkingGroup) {
            //     $userWorkingGroups[] = UserWorkingGroup::fromValue($userWorkingGroup);
            // }

            $users[] = new User(
                new UserId($entity->id),
                new OrganizationId($entity->organization_id ?? 1),
                UserType::fromValue($entity->type ?? 'admin'),
                (bool)$entity->active,
                $entity->first_name,
                $entity->last_name,
                $entity->first_name_furigana,
                $entity->last_name_furigana,
                [],
                GenderType::fromValue($entity->gender ?? 'male'),
                $entity->email,
                (bool)$entity->receive_space_search_form_notification,
                (bool)$entity->subscribe_mail_magazine,
                $userRoles,
                $userWorkingGroups,
                $entity->password,
                $entity->creation_time,
                $entity->last_login_time,
                $entity->organization_name
            );
            // dd($users);
        }

        $pagination = new Pagination(
            $entities->lastPage(),
            $entities->perPage(),
            $entities->currentPage()
        );

        return [
            $users,
            $pagination
        ];
    }

    /**
     * @inheritDoc
     */
    public function updateUser(User $user): UserId
    {
        $entity = ModelUser::find($user->getUserId()->getValue());

        $data = [
            'active' => $user->getIsActive(),
            'email' => $user->getEmail(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'first_name_furigana' => $user->getFirstNameFurigana(),
            'last_name_furigana' => $user->getLastNameFurigana(),
            'gender' => $user->getGenderType()->getValue(),
            'receive_space_search_form_notification' => $user->getRequestNotification(),
            'subscribe_mail_magazine' => $user->getReceiveEmail(),
            'organization_id' => $user->getOrganizationId()->getValue(),
            'roles' => $user->getUserRoleWithJson(),
            'working_groups' => $user->getUserWorkingGroupsWithJson(),
            'type' => $user->getUserType()->getValue(),
            'organization_name' => $user->getOrganizationName()
        ];
        if ($user->getPassword()) {
            $data['password'] = $user->getPassword();
        }
        $entity->update($data);

        return new UserId($entity->id);
    }

    public function getAllNameSpaceByUser(int $userId)
    {
        $query = ModelReservation::where('user_id', $userId)->select(['id', 'rental_space_id'])->get()->unique('rental_space_id');

        $result = [];
        foreach ($query->toArray() as $item) {
            $nameSpace = ModelRentalSpaceEav::where('attribute', 'generalBasicSpaceNameJa')->where('namespace', $item['rental_space_id'])->first();

            if (!empty($nameSpace)) {
                $item['nameSpace'] = $nameSpace->value;
                $result[] = $item;
            }
        }

        return $result;
    }

    public function handleResetPassword($email)
    {
        try {
            $sql = ModelUser::where('email', $email)->first();
            if (empty($sql)) {
                return [
                    'status' => Response::HTTP_NOT_FOUND,
                    'msg' => CommonConstant::MSG_EXISTS_DATA,
                ];
            }

            $randomPassword = Str::random(10);
            $hashPassWord = Hash::make($randomPassword);

            $data = $sql->update(['password' => $hashPassWord]);
            $this->handleSendMailResetPassword($email, $randomPassword);

            return [
                'data' => $data,
                'status' => Response::HTTP_OK,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS
            ];
        }
    }

    public function handleSendMailResetPassword($email, $newPassword)
    {
        $data['email'] = $email;
        $data['newPassword'] = $newPassword;

        return Mail::send('mail.SendMailResetPassWordUser', ['data' => $data], function ($m) use ($email) {
            $m->to($email)->subject('title reset pw');
        });
    }
}
