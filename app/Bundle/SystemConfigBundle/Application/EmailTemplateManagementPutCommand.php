<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class EmailTemplateManagementPutCommand
{
    public string $emailType;
    public ?string $emailSubjectEn;
    public string $emailSubjectJp;
    public ?string $contentEn;
    public string $contentJp;
    public ?string $memoEn;
    public ?string $memoJp;
    public int $emailTemplateId;

    /**
     * @param int $emailTemplateId
     * @param string $emailType
     * @param string|null $emailSubjectEn
     * @param string $emailSubjectJp
     * @param string|null $contentEn
     * @param string $contentJp
     * @param string|null $memoEn
     * @param string|null $memoJp
     */
    public function __construct(
        int     $emailTemplateId,
        string  $emailType,
        ?string $emailSubjectEn,
        string  $emailSubjectJp,
        ?string $contentEn,
        string  $contentJp,
        ?string $memoEn,
        ?string $memoJp
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
}
