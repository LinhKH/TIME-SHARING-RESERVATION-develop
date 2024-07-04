<?php

namespace App\Bundle\OrganizationBundle\Application;

use Illuminate\Support\Facades\DB;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\OrganizationBundle\Application\OrganizationPostCommand;
use App\Bundle\OrganizationBundle\Application\OrganizationPostResult;
use App\Bundle\OrganizationBundle\Domain\Model\IOrganizationRepository;
use App\Bundle\OrganizationBundle\Domain\Model\Organization;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationInformation;

final class OrganizationPostApplicationService
{
    /**
     * OrganizationRepository
     * 
     * @var IOrganizationRepository $organizationRepository
     */
    private IOrganizationRepository $organizationRepository;

    /**
     * @param \App\Bundle\OrganizationBundle\Domain\Model\IOrganizationRepository $sampleRepository sampleRepository
     */
    public function __construct(
        IOrganizationRepository $organizationRepository
    ) {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * @param \App\Bundle\OrganizationBundle\Application\OrganizationPostCommand $command command
     * @return \App\Bundle\OrganizationBundle\Application\OrganizationResult
     */
    public function handle(OrganizationPostCommand $command): OrganizationPostResult
    {
        $organization = new Organization(
            null,
            $command->name,
            $command->nameFurigana,
            $command->note,
            $command->active
        );

        \DB::beginTransaction();
        try {
            $organizationId = $this->organizationRepository->createOrganization($organization);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error($e);
            throw new TransactionException('更新できませんでした');
        }

        return new OrganizationPostResult(
            $organizationId->getValue()
        );
    }
}
