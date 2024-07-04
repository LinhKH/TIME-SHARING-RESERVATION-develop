<?php

namespace App\Bundle\SystemConfigBundle\Application;

class EmailTemplateManagementDeleteResult
{
    public bool $deleteEmailTemplate;

    /**
     * @param bool $deleteEmailTemplate
     */
    public function __construct(
        bool $deleteEmailTemplate
    ){
        $this->deleteEmailTemplate = $deleteEmailTemplate;
    }
}
