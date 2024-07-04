<?php

namespace App\Bundle\OrganizationBundle\Domain\Model;

final class OrganizationBankAccount
{
    private int $id;
    private string $accountNumber;
    private string $bankCode;
    private string $bankName;
    private ?string $bankNameKatakana;
    private string $branchCode;
    private string $branchName;
    private ?string $branchNameKatakana;
    private ?string $holderNameKatakana;
    private int $creationTime;
    private string $type;

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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    /**
     * @return string
     */
    public function getBankCode(): string
    {
        return $this->bankCode;
    }

    /**
     * @return string
     */
    public function getBankName(): string
    {
        return $this->bankName;
    }

    /**
     * @return string|null
     */
    public function getBankNameKatakana(): ?string
    {
        return $this->bankNameKatakana;
    }

    /**
     * @return string
     */
    public function getBranchCode(): string
    {
        return $this->branchCode;
    }

    /**
     * @return string
     */
    public function getBranchName(): string
    {
        return $this->branchName;
    }

    /**
     * @return string|null
     */
    public function getBranchNameKatakana(): ?string
    {
        return $this->branchNameKatakana;
    }

    /**
     * @return string|null
     */
    public function getHolderNameKatakana(): ?string
    {
        return $this->holderNameKatakana;
    }

    /**
     * @return int
     */
    public function getCreationTime(): int
    {
        return $this->creationTime;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

}
