<?php
namespace App\Bundle\SystemConfigBundle\Domain\Model;

interface ISystemConfigRepository
{
    /**
     * @param SystemConfigId $systemConfigId systemConfigId
     * @return SystemConfig|null
     */
    public function findById(SystemConfigId $systemConfigId): ?SystemConfig;

    /**
     * @return SystemConfig|null
     */
    public function findByDefault(): ?SystemConfig;
}
