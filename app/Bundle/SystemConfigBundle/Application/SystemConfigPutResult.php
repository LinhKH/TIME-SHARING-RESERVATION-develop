<?php
namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigPutResult
{
     public string $systemConfigId;
    /**
     * @param string $systemConfigId systemConfigId
     */
    public function __construct(string $systemConfigId) 
    {
        $this->systemConfigId = $systemConfigId;
    }
}