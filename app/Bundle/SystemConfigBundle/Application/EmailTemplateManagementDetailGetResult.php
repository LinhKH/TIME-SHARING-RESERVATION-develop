<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class EmailTemplateManagementDetailGetResult
{
    public EmailTemplateManagement $emailTemplate;

    /**
     * @param EmailTemplateManagement $emailTemplate
     */
    public function __construct(
        EmailTemplateManagement $emailTemplate
    ) {
        $this->emailTemplate = $emailTemplate;

    }
}
