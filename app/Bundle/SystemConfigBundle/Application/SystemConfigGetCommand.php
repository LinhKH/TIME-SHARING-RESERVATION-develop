<?php
namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigGetCommand
{
    public ?string $systemConfigId;

    /**
     * @param string|null $systemConfigId systemConfigId
     */
    public function __construct(
        ?string $systemConfigId
    ){
        $this->systemConfigId = $systemConfigId;
    }
}
