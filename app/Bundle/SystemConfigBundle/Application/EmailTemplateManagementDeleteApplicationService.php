<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\EmailTemplateId;
use App\Bundle\SystemConfigBundle\Domain\Model\IEmailTemplateRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class EmailTemplateManagementDeleteApplicationService
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
     * @param EmailTemplateManagementDeleteCommand $command
     * @return EmailTemplateManagementDetailGetResult|null
     * @throws InvalidArgumentException
     * @throws TransactionException
     */
    public function handle(EmailTemplateManagementDeleteCommand $command): ?EmailTemplateManagementDeleteResult
    {
        $emailTemplateId = new EmailTemplateId($command->emailTemplateId);

        DB::beginTransaction();
        try {
            $emailTemplate = $this->emailTemplateRepository->deleteEmailTemplate($emailTemplateId);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
        return new EmailTemplateManagementDeleteResult(
            $emailTemplate
        );
    }
}
