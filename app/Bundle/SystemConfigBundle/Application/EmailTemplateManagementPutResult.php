<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class EmailTemplateManagementPutResult
{
    public int $emailTemplateId;

    /**
     * @param int $emailTemplateId
     */
    public function __construct(
        int $emailTemplateId
    ){
        $this->emailTemplateId = $emailTemplateId;
    }
}
