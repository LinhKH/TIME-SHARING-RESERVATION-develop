<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class EmailTemplateManagementListGetResult
{
    public array $emailTemplates;

    /**
     * @param EmailTemplateManagement[] $emailTemplates
     */
    public function __construct(
        array $emailTemplates
    ) {
        $this->emailTemplates = $emailTemplates;

    }
}
