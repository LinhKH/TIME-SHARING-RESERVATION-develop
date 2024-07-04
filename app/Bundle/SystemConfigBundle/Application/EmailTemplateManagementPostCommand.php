<?php

namespace App\Bundle\SystemConfigBundle\Application;

final class EmailTemplateManagementPostCommand
{
    public string $emailType;
    public ?string $emailSubjectEn;
    public string $emailSubjectJp;
    public ?string $contentEn;
    public string $contentJp;
    public ?string $memoEn;
    public ?string $memoJp;

    /**
     * @param string $emailType
     * @param string|null $emailSubjectEn
     * @param string $emailSubjectJp
     * @param string|null $contentEn
     * @param string $contentJp
     * @param string|null $memoEn
     * @param string|null $memoJp
     */
    public function __construct(
        string  $emailType,
        ?string $emailSubjectEn,
        string  $emailSubjectJp,
        ?string $contentEn,
        string  $contentJp,
        ?string $memoEn,
        ?string $memoJp
    )
    {
        $this->memoJp = $memoJp;
        $this->memoEn = $memoEn;
        $this->contentJp = $contentJp;
        $this->contentEn = $contentEn;
        $this->emailSubjectJp = $emailSubjectJp;
        $this->emailSubjectEn = $emailSubjectEn;
        $this->emailType = $emailType;
    }
}
