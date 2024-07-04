<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\EmailTemplate;
use App\Bundle\SystemConfigBundle\Domain\Model\EmailTemplateId;
use App\Bundle\SystemConfigBundle\Domain\Model\IEmailTemplateRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class EmailTemplateManagementPutApplicationService
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
     * @param EmailTemplateManagementPutCommand $command
     * @return EmailTemplateManagementPutResult
     * @throws TransactionException
     * @throws InvalidArgumentException
     */
    public function handle(EmailTemplateManagementPutCommand $command): EmailTemplateManagementPutResult
    {
        $emailTemplate = new EmailTemplate(
            new EmailTemplateId($command->emailTemplateId),
            $command->emailType,
            $command->emailSubjectEn,
            $command->emailSubjectJp,
            $command->contentEn,
            $command->contentJp,
            $command->memoEn,
            $command->memoJp
        );

        DB::beginTransaction();
        try {
            $emailTemplateId = $this->emailTemplateRepository->updateEmailTemplate($emailTemplate);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new EmailTemplateManagementPutResult(
            $emailTemplateId->getValue()
        );
    }
}
