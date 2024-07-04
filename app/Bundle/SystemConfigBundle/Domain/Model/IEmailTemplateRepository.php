<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

interface IEmailTemplateRepository
{
    /**
     * Create Email template
     *
     * @param EmailTemplate $emailTemplate
     * @return EmailTemplateId
     */
    public function createEmailTemplate(EmailTemplate $emailTemplate): EmailTemplateId;

    /**
     * Detail Email template
     *
     * @param EmailTemplateId $emailTemplateId
     * @return EmailTemplate|null
     */
    public function findEmailTemplate(EmailTemplateId $emailTemplateId): ?EmailTemplate;

    /**
     * List all email template
     *
     * @return EmailTemplate[]
     */
    public function findAll(): array;

    /**
     * Update email template
     *
     * @param EmailTemplate $emailTemplate
     * @return EmailTemplateId
     */
    public function updateEmailTemplate(EmailTemplate $emailTemplate): EmailTemplateId;

    /**
     * @param EmailTemplateId $emailTemplateId
     * @return boolean
     */
    public function deleteEmailTemplate(EmailTemplateId $emailTemplateId): bool;
}
