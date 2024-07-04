<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

final class EmailTemplate
{
    private string $emailType;
    private ?string $emailSubjectEn;
    private string $emailSubjectJp;
    private ?string $contentEn;
    private string $contentJp;
    private ?string $memoEn;
    private ?string $memoJp;
    private ?EmailTemplateId $emailTemplateId;

    /**
     * @param EmailTemplateId|null $emailTemplateId
     * @param string $emailType
     * @param string|null $emailSubjectEn
     * @param string $emailSubjectJp
     * @param string|null $contentEn
     * @param string $contentJp
     * @param string|null $memoEn
     * @param string|null $memoJp
     */
    public function __construct(
        ?EmailTemplateId $emailTemplateId,
        string           $emailType,
        ?string          $emailSubjectEn,
        string           $emailSubjectJp,
        ?string          $contentEn,
        string           $contentJp,
        ?string          $memoEn,
        ?string          $memoJp
    )
    {
        $this->emailTemplateId = $emailTemplateId;
        $this->memoJp = $memoJp;
        $this->memoEn = $memoEn;
        $this->contentJp = $contentJp;
        $this->contentEn = $contentEn;
        $this->emailSubjectJp = $emailSubjectJp;
        $this->emailSubjectEn = $emailSubjectEn;
        $this->emailType = $emailType;
    }

    /**
     * @return string
     */
    public function getEmailType(): string
    {
        return $this->emailType;
    }

    /**
     * @return string
     */
    public function getEmailSubjectEn(): string
    {
        return $this->emailSubjectEn ?? '';
    }

    /**
     * @return string
     */
    public function getEmailSubjectJp(): string
    {
        return $this->emailSubjectJp;
    }

    /**
     * @return string
     */
    public function getContentEn(): string
    {
        return $this->contentEn ?? '';
    }

    /**
     * @return string
     */
    public function getContentJp(): string
    {
        return $this->contentJp;
    }

    /**
     * @return string|null
     */
    public function getMemoEn(): ?string
    {
        return $this->memoEn;
    }

    /**
     * @return string|null
     */
    public function getMemoJp(): ?string
    {
        return $this->memoJp;
    }

    /**
     * @return EmailTemplateId|null
     */
    public function getEmailTemplateId(): ?EmailTemplateId
    {
        return $this->emailTemplateId;
    }


}
