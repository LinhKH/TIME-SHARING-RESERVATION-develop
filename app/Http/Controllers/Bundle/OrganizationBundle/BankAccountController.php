<?php

namespace App\Http\Controllers\Bundle\OrganizationBundle;

use App\Bundle\OrganizationBundle\Application\OrganizationBankAccountListGetApplicationService;
use App\Bundle\OrganizationBundle\Application\OrganizationBankAccountListGetCommand;
use App\Bundle\OrganizationBundle\Infrastructure\OrganizationBankAccountRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BankAccountController extends Controller
{

    /**
     * API - GET all Bank account
     *
     * @param int $organizationId
     * @return JsonResponse
     */
    public function getAllBankAccount(int $organizationId): JsonResponse
    {
        $bankAccountRepository = new OrganizationBankAccountRepository();
        $applicationService = new OrganizationBankAccountListGetApplicationService(
            $bankAccountRepository
        );
        $command = new OrganizationBankAccountListGetCommand($organizationId);
        $organizationBankAccounts = $applicationService->handle($command);

        $data = [];
        foreach ($organizationBankAccounts as $bankAccounts) {
            foreach ($bankAccounts as $bankAccount) {
                $data[] = [
                    'id' => $bankAccount->id,
                    'account_number' => $bankAccount->accountNumber,
                    'bank_code' => $bankAccount->bankCode,
                    'bank_name' => $bankAccount->bankName,
                    'bank_name_katakana' => $bankAccount->bankNameKatakana,
                    'branch_code' => $bankAccount->branchCode,
                    'branch_name' => $bankAccount->branchName,
                    'branch_name_katakana' => $bankAccount->branchNameKatakana,
                    'holder_name_katakana' => $bankAccount->holderNameKatakana,
                    'creation_time' => $bankAccount->creationTime,
                    'type' => $bankAccount->type,
                ];
            }
        }

        return response()->json($data, 200);
    }
}
