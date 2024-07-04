<?php

namespace App\Http\Controllers\Bundle\UserBundle;

use App\Bundle\UserBundle\Application\UserManageGetApplicationService;
use App\Bundle\UserBundle\Application\UserManageGetCommand;
use App\Bundle\UserBundle\Application\UserManageListGetApplicationService;
use App\Bundle\UserBundle\Application\UserManageListGetCommand;
use App\Bundle\UserBundle\Application\UserManagePostApplicationService;
use App\Bundle\UserBundle\Application\UserManagePostCommand;
use App\Bundle\UserBundle\Application\UserManagePutApplicationService;
use App\Bundle\UserBundle\Application\UserManagePutCommand;
use App\Bundle\UserBundle\Infrastructure\OrganizationRepository;
use App\Bundle\UserBundle\Infrastructure\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserManagePostRequest;
use App\Http\Requests\UserManagePutRequest;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function manageAction(Request $request)
    {
        $userRepository = new UserRepository();
        $organizationRepository = new OrganizationRepository();
        $applicationService = new UserManageListGetApplicationService(
            $userRepository,
            $organizationRepository
        );
        $command = new UserManageListGetCommand();

        $result = $applicationService->handle($command, $request->all());

        $userManageResults = $result->userManageResult;
        $paginationResult = $result->paginationResult;
        $data = [];
        if(!empty($userManageResults)) {
            foreach ($userManageResults as $userManageResult) {
                $data[] = [
                    'user_id' => $userManageResult->userId,
                    'user_email' => $userManageResult->userEmail,
                    'user_name' => $userManageResult->userName,
                    'company_name' => $userManageResult->companyName,
                    'user_type' => $userManageResult->userType,
                    'user_active' => $userManageResult->userActive,
                    'register_date' => $userManageResult->registerDate,
                    'login_last_date' => $userManageResult->loginLastDate,
                ];
            }
        }
        $response = [
            'data' => $data,
            'pagination' => [
                'total' => $paginationResult->totalPage,
                'per_page' => $paginationResult->perPage,
                'current_page' => $paginationResult->currentPage,
            ],
        ];

        return response()->json($response, 200);
    }

    public function addAction(UserManagePostRequest $request)
    {
        $userRepository = new UserRepository();
        $applicationService = new UserManagePostApplicationService($userRepository);

        $command = new UserManagePostCommand(
            $request->user_type,
            $request->organization_id,
            (bool)$request->active,
            $request->email,
            $request->first_name,
            $request->last_name,
            $request->first_name_furigana,
            $request->last_name_furigana,
            [],
            bcrypt($request->password),
            $request->gender_type,
            (bool)$request->request_notification,
            (bool)$request->receive_newsletter,
            $request->user['roles'],
            $request->user['working_groups'],
            $request->organization_name ?? null
        );
        $result = $applicationService->handle($command);

        return response()->json(['user_id' => $result->userId], 200);
    }

    public function getUser(Request $request)
    {
        $userRepository = new UserRepository();
        $organizationRepository = new OrganizationRepository();
        $applicationService = new UserManageGetApplicationService($userRepository, $organizationRepository);

        $command = new UserManageGetCommand((int)$request->id);
        $user = $applicationService->handle($command);
        $data = [
            'user_id' => $user->userId,
            'user_type' => $user->userType,
            'organization_id' => $user->organizationId,
            'organization_name' => $user->organizationName,
            'active' => $user->active,
            'email' => $user->email,
            'first_name' => $user->firstName,
            'last_name' => $user->lastName,
            'first_name_furigana' => $user->firstNameFurigana,
            'last_name_furigana' => $user->lastNameFurigana,
            'files' => $user->files,
            'gender' => $user->gender,
            'request_notification' => $user->isRequestNotification,
            'receive_newsletter' => $user->isReceiveNewsletter,
            'roles' => $user->userRoles,
            'working_groups' => $user->userWorkingGroups,
            'register_date' => $user->registerDate,
            'login_last_date' => $user->loginLastDate,
        ];

        $userRepository = new UserRepository();
        $nameSpace = $userRepository->getAllNameSpaceByUser($request->id);
        $data['nameSpace'] = $nameSpace;

        return response()->json($data, 200);
    }

    public function updateUser(UserManagePutRequest $request)
    {
        $userRepository = new UserRepository();
        $applicationService = new UserManagePutApplicationService($userRepository);

        $command = new UserManagePutCommand(
            (int)$request->id,
            $request->user_type,
            $request->organization_id,
            (bool)$request->active,
            $request->email,
            $request->first_name,
            $request->last_name,
            $request->first_name_furigana,
            $request->last_name_furigana,
            [],
            $request->password ? bcrypt($request->password) : null,
            $request->gender_type,
            (bool)$request->request_notification,
            (bool)$request->receive_newsletter,
            $request->user['roles'],
            $request->user['working_groups'],
            $request->organization_name ?? null
        );
        $result = $applicationService->handle($command);

        return response()->json(['user_id' => $result->userId], 200);
    }


    public function handleResetPassword($email)
    {
        $userRepository = new UserRepository();
        $result =  $userRepository->handleResetPassword($email);

        return response()->json($result, 200);
    }
}
