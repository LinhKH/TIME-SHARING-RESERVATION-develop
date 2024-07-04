<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\EmailTemplate;
use App\Bundle\SystemConfigBundle\Domain\Model\IEmailTemplateRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class EmailTemplateManagementPostApplicationService
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
     * @param EmailTemplateManagementPostCommand $command
     * @return EmailTemplateManagementPostResult
     * @throws TransactionException
     */
    public function handle(EmailTemplateManagementPostCommand $command): EmailTemplateManagementPostResult
    {
        $emailTemplate = new EmailTemplate(
          null,
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
            $emailTemplateId = $this->emailTemplateRepository->createEmailTemplate($emailTemplate);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new EmailTemplateManagementPostResult(
            $emailTemplateId->getValue()
        );
    }
}
