<?php

namespace App\Bundle\OrganizationBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\OrganizationBundle\Domain\Model\IOrganizationRepository;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;
use Illuminate\Support\Facades\App;

final class OrganizationGetApplicationService
{

    /**
     * @var IOrganizationRepository
     */
    private IOrganizationRepository $organizationRepository;

    /**
     * OrganizationGetApplicationService constructor.
     * @param IOrganizationRepository $organizationRepository
     */
    public function __construct(
        IOrganizationRepository $organizationRepository
    )
    {
        $this->organizationRepository = $organizationRepository;
    }

    /**
     * @param OrganizationGetCommand $organizationGetCommand
     * @return OrganizationGetResult
     * @throws RecordNotFoundException
     */
    public function handle(OrganizationGetCommand $organizationGetCommand): OrganizationGetResult
    {
        $organizationId = new OrganizationId($organizationGetCommand->organizationId);
        $organization = $this->organizationRepository->findById($organizationId);

        if (!$organization) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }

        return new OrganizationGetResult(
            $organization->getOrganizationId()->getValue(),
            $organization->getName(),
            $organization->getNameFurigana(),
            $organization->getNote(),
            $organization->getActive()
        );
    }

}
