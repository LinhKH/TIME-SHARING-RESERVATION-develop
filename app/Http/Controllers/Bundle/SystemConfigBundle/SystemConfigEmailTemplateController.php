<?php

namespace App\Http\Controllers\Bundle\SystemConfigBundle;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Application\EmailTemplateManagementDeleteApplicationService;
use App\Bundle\SystemConfigBundle\Application\EmailTemplateManagementDeleteCommand;
use App\Bundle\SystemConfigBundle\Application\EmailTemplateManagementDetailGetApplicationService;
use App\Bundle\SystemConfigBundle\Application\EmailTemplateManagementDetailGetCommand;
use App\Bundle\SystemConfigBundle\Application\EmailTemplateManagementListGetApplicationService;
use App\Bundle\SystemConfigBundle\Application\EmailTemplateManagementPostApplicationService;
use App\Bundle\SystemConfigBundle\Application\EmailTemplateManagementPostCommand;
use App\Bundle\SystemConfigBundle\Application\EmailTemplateManagementPutApplicationService;
use App\Bundle\SystemConfigBundle\Application\EmailTemplateManagementPutCommand;
use App\Bundle\SystemConfigBundle\Infrastructure\EmailTemplateRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\SystemConfigEmailTemplateRequest;
use Illuminate\Http\JsonResponse;

class SystemConfigEmailTemplateController extends Controller
{
    /**
     * Detail Email template
     */
    public function listEmailTemplate(): JsonResponse
    {
        $emailTemplateRepository = new EmailTemplateRepository();
        $application = new EmailTemplateManagementListGetApplicationService($emailTemplateRepository);

        $emailTemplates = $application->handle();

        $results = [];
        foreach ($emailTemplates->emailTemplates as $emailTemplate) {

            $results[] = [
                "id" => $emailTemplate->emailTemplateId,
                "email_type" => $emailTemplate->emailType,
                "email_subject_en" => $emailTemplate->emailSubjectEn,
                "email_subject_jp" => $emailTemplate->emailSubjectJp,
                "content_en" => $emailTemplate->contentEn,
                "content_jp" => $emailTemplate->contentJp,
                "memo_en" => $emailTemplate->memoEn ?? '',
                "memo_jp" => $emailTemplate->memoJp ?? ''
            ];
        }
        return response()->json([
            'status' => 200,
            'data' => $results
        ], 200);
    }

    /**
     * Create email template
     *
     * @param SystemConfigEmailTemplateRequest $request
     * @return JsonResponse
     * @throws \App\Bundle\Common\Domain\Model\TransactionException
     */
    public function createEmailTemplate(SystemConfigEmailTemplateRequest $request): JsonResponse
    {
        $emailTemplateRepository = new EmailTemplateRepository();
        $application = new EmailTemplateManagementPostApplicationService($emailTemplateRepository);

        $command = new EmailTemplateManagementPostCommand(
            $request->email_type,
            $request->email_subject_en ?? '',
            $request->email_subject_jp,
            $request->content_en ?? '',
            $request->content_jp,
            $request->memo_en ?? null,
            $request->memo_jp ?? null
        );
        $result = $application->handle($command);
        return response()->json([
            'status' => 200,
            'message' => "Create email template successfully !",
            'email_template_id' => $result->emailTemplateId
        ], 200);
    }

    /**
     * Detail Email template
     */
    public function detailEmailTemplate($emailTemplateId): JsonResponse
    {
        $emailTemplateRepository = new EmailTemplateRepository();
        $application = new EmailTemplateManagementDetailGetApplicationService($emailTemplateRepository);

        $command = new EmailTemplateManagementDetailGetCommand(
            $emailTemplateId
        );
        $result = $application->handle($command);

        if (empty($result)) {
            return response()->json([
                'status' => 401,
                'message' => "Email template Id not exists !",
            ], 401);
        }
        return response()->json([
            'status' => 200,
            'data' => [
                'email_type' => $result->emailTemplate->emailType,
                'email_subject_en' => $result->emailTemplate->emailSubjectEn,
                'email_subject_jp' => $result->emailTemplate->emailSubjectJp,
                'content_en' => $result->emailTemplate->contentEn,
                'content_jp' => $result->emailTemplate->contentJp,
                'memo_en' => $result->emailTemplate->memoEn,
                'memo_jp' => $result->emailTemplate->memoJp
            ]
        ], 200);
    }

    /**
     * Update email template
     *
     * @param $emailTemplateId
     * @param SystemConfigEmailTemplateRequest $request
     * @return JsonResponse
     * @throws TransactionException|\App\Bundle\Common\Domain\Model\InvalidArgumentException
     */
    public function updateEmailTemplate($emailTemplateId, SystemConfigEmailTemplateRequest $request): JsonResponse
    {
        $emailTemplateRepository = new EmailTemplateRepository();
        $application = new EmailTemplateManagementPutApplicationService($emailTemplateRepository);

        $command = new EmailTemplateManagementPutCommand(
            $emailTemplateId,
            $request->email_type,
            $request->email_subject_en ?? null,
            $request->email_subject_jp,
            $request->content_en ?? null,
            $request->content_jp,
            $request->memo_en ?? null,
            $request->memo_jp ?? null
        );
        $result = $application->handle($command);
        return response()->json([
            'status' => 200,
            'message' => "Update email template successfully !",
            'email_template_id' => $result->emailTemplateId
        ], 200);
    }

    /**
     * @param $emailTemplateId
     * @return JsonResponse
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function deleteEmailTemplate($emailTemplateId): JsonResponse
    {
        $emailTemplateRepository = new EmailTemplateRepository();
        $application = new EmailTemplateManagementDeleteApplicationService($emailTemplateRepository);

        $command = new EmailTemplateManagementDeleteCommand($emailTemplateId);
        $result = $application->handle($command);
        return response()->json([
            'status' => 200,
            'message' => "Delete email templateID={$emailTemplateId} successfully !",
        ], 200);
    }
}
