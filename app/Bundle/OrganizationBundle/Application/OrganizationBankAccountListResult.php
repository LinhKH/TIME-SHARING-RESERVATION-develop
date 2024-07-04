<?php

namespace App\Bundle\OrganizationBundle\Application;

final class OrganizationBankAccountListResult
{

    public int $id;
    public string $accountNumber;
    public string $bankCode;
    public string $bankName;
    public ?string $bankNameKatakana;
    public string $branchCode;
    public string $branchName;
    public ?string $branchNameKatakana;
    public ?string $holderNameKatakana;
    public int $creationTime;
    public string $type;

    /**
     * @param int $id
     * @param string $accountNumber
     * @param string $bankCode
     * @param string $bankName
     * @param string|null $bankNameKatakana
     * @param string $branchCode
     * @param string $branchName
     * @param string|null $branchNameKatakana
     * @param string|null $holderNameKatakana
     * @param int $creationTime
     * @param string $type
     */
    public function __construct(
        int     $id,
        string  $accountNumber,
        string  $bankCode,
        string  $bankName,
        ?string $bankNameKatakana,
        string  $branchCode,
        string  $branchName,
        ?string $branchNameKatakana,
        ?string $holderNameKatakana,
        int     $creationTime,
        string  $type
    )
    {
        $this->id = $id;
        $this->accountNumber = $accountNumber;
        $this->bankCode = $bankCode;
        $this->bankName = $bankName;
        $this->bankNameKatakana = $bankNameKatakana;
        $this->branchCode = $branchCode;
        $this->branchName = $branchName;
        $this->branchNameKatakana = $branchNameKatakana;
        $this->holderNameKatakana = $holderNameKatakana;
        $this->creationTime = $creationTime;
        $this->type = $type;
    }
}
