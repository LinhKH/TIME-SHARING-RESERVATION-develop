<?php

namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\IEmailTemplateRepository;

final class EmailTemplateManagementListGetApplicationService
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
     * @return EmailTemplateManagementListGetResult
     */
    public function handle(): EmailTemplateManagementListGetResult
    {

        $emailTemplates = $this->emailTemplateRepository->findAll();

        $results = [];
        foreach ($emailTemplates as $emailTemplate) {
            $results[] = new EmailTemplateManagement(
                $emailTemplate->getEmailTemplateId()->getValue(),
                $emailTemplate->getEmailType(),
                $emailTemplate->getEmailSubjectEn(),
                $emailTemplate->getEmailSubjectJp(),
                $emailTemplate->getContentEn(),
                $emailTemplate->getContentJp(),
                $emailTemplate->getMemoEn(),
                $emailTemplate->getMemoJp()
            );
        }
        return new EmailTemplateManagementListGetResult(
            $results
        );
    }
}
