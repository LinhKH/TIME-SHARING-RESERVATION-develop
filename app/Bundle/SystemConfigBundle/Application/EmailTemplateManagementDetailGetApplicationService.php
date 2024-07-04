<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\EmailTemplateId;
use App\Bundle\SystemConfigBundle\Domain\Model\IEmailTemplateRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class EmailTemplateManagementDetailGetApplicationService
{
    private IEmailTemplateRepository $emailTemplateRepository;

    /**
     * @param IEmailTemplateRepository $emailTemplateRepository
     */
    public function __construct(
        IEmailTemplateRepository $emailTemplateRepository
    ) {
        $this->emailTemplateRepository = $emailTemplateRepository;
    }

    /**
     * @param EmailTemplateManagementDetailGetCommand $command
     * @return EmailTemplateManagementDetailGetResult|null
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function handle(EmailTemplateManagementDetailGetCommand $command): ?EmailTemplateManagementDetailGetResult
    {
        $emailTemplateId = new EmailTemplateId($command->emailTemplateId);

        DB::beginTransaction();
        try {
            $emailTemplate = $this->emailTemplateRepository->findEmailTemplate($emailTemplateId);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
        if (empty($emailTemplate)) {
            return null;
        }
        $emailTemplateManagement = new EmailTemplateManagement(
            $emailTemplate->getEmailTemplateId()->getValue(),
            $emailTemplate->getEmailType(),
            $emailTemplate->getEmailSubjectEn(),
            $emailTemplate->getEmailSubjectJp(),
            $emailTemplate->getContentEn(),
            $emailTemplate->getContentJp(),
            $emailTemplate->getMemoEn(),
            $emailTemplate->getMemoJp()
        );
        return new EmailTemplateManagementDetailGetResult(
            $emailTemplateManagement
        );
    }
}
