<?php

namespace App\Bundle\OrganizationBundle\Application;

use App\Bundle\OrganizationBundle\Domain\Model\IOrganizationBankAccountRepository;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;

final class OrganizationBankAccountListGetApplicationService
{
    /**
     * RentalSpaceGeneralRepository
     *
     * @var IOrganizationBankAccountRepository
     */
    private IOrganizationBankAccountRepository $bankAccountRepository;


    /**
     *
     */
    public function __construct(
        IOrganizationBankAccountRepository $bankAccountRepository
    ) {
        $this->bankAccountRepository = $bankAccountRepository;

    }

    /**
     * @param OrganizationBankAccountListGetCommand $command
     * @return OrganizationBankAccountListGetResult
     */
    public function handle(OrganizationBankAccountListGetCommand $command): OrganizationBankAccountListGetResult
    {
        $organizationId = new OrganizationId($command->organizationId);
        $bankAccounts = $this->bankAccountRepository->findAll($organizationId);

        /** @var OrganizationBankAccountListGetResult[] $bankAccountResults*/
        $bankAccountResults = [];

        foreach ($bankAccounts as $bankAccount) {
            $bankAccountResults[] = new OrganizationBankAccountListResult(
                $bankAccount->getId(),
                $bankAccount->getAccountNumber(),
                $bankAccount->getBankCode(),
                $bankAccount->getBankName(),
                $bankAccount->getBankNameKatakana(),
                $bankAccount->getBranchCode(),
                $bankAccount->getBranchName(),
                $bankAccount->getBranchNameKatakana(),
                $bankAccount->getHolderNameKatakana(),
                $bankAccount->getCreationTime(),
                $bankAccount->getType()
            );
        }

        return new OrganizationBankAccountListGetResult($bankAccountResults);
    }
}
