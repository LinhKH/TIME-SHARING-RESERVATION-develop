<?php

namespace App\Bundle\SystemConfigBundle\Infrastructure;

use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\SystemConfigBundle\Domain\Model\EmailTemplate;
use App\Bundle\SystemConfigBundle\Domain\Model\EmailTemplateId;
use App\Bundle\SystemConfigBundle\Domain\Model\IEmailTemplateRepository;
use App\Models\EmailTemplate as ModelEmailTemplate;

class EmailTemplateRepository implements IEmailTemplateRepository
{

    /**
     * @param EmailTemplate $emailTemplate
     * @return EmailTemplateId
     * @throws InvalidArgumentException
     */
    public function createEmailTemplate(EmailTemplate $emailTemplate): EmailTemplateId
    {
        // TODO: Implement createEmailTemplate() method.
        $entity = ModelEmailTemplate::create([
            'email_type' => $emailTemplate->getEmailType(),
            'email_subject_en' => $emailTemplate->getEmailSubjectEn(),
            'email_subject_jp' => $emailTemplate->getEmailSubjectJp(),
            'content_en' => $emailTemplate->getContentEn(),
            'content_jp' => $emailTemplate->getContentJp(),
            'memo_en' => $emailTemplate->getMemoEn(),
            'memo_jp' => $emailTemplate->getMemoJp()
        ]);

        return new EmailTemplateId($entity->id);
    }

    /**
     * @param EmailTemplateId $emailTemplateId
     * @return EmailTemplate|null
     * @throws InvalidArgumentException
     */
    public function findEmailTemplate(EmailTemplateId $emailTemplateId): ?EmailTemplate
    {
        // TODO: Implement detailEmailTemplate() method.
        $emailTemplate = ModelEmailTemplate::find($emailTemplateId->getValue());

        if (empty($emailTemplate)) {
            return null;
        }

        return new EmailTemplate(
            new EmailTemplateId($emailTemplate->id),
            $emailTemplate->email_type,
            $emailTemplate->email_subject_en,
            $emailTemplate->email_subject_jp,
            $emailTemplate->content_en,
            $emailTemplate->content_jp,
            $emailTemplate->memo_en,
            $emailTemplate->memo_jp
        );
    }

    /**
     * @return EmailTemplate[]
     * @throws InvalidArgumentException
     */
    public function findAll(): array
    {
        // TODO: Implement findAll() method.
        $emailTemplates = ModelEmailTemplate::all()->toArray();
        $results = [];

        foreach ($emailTemplates as $emailTemplate) {
            $results[] = new EmailTemplate(
                new EmailTemplateId($emailTemplate['id']),
                $emailTemplate['email_type'],
                $emailTemplate['email_subject_en'],
                $emailTemplate['email_subject_jp'],
                $emailTemplate['content_en'],
                $emailTemplate['content_jp'],
                $emailTemplate['memo_en'],
                $emailTemplate['memo_jp']
            );
        }
        return $results;
    }

    /**
     * @param EmailTemplate $emailTemplate
     * @return EmailTemplateId
     * @throws InvalidArgumentException
     */
    public function updateEmailTemplate(EmailTemplate $emailTemplate): EmailTemplateId
    {
        // TODO: Implement updateEmailTemplate() method.
        $entity = ModelEmailTemplate::findOrFail($emailTemplate->getEmailTemplateId()->getValue());
        $entity->update([
            'email_type' => $emailTemplate->getEmailType(),
            'email_subject_en' => $emailTemplate->getEmailSubjectEn(),
            'email_subject_jp' => $emailTemplate->getEmailSubjectJp(),
            'content_en' => $emailTemplate->getContentEn(),
            'content_jp' => $emailTemplate->getContentJp(),
            'memo_en' => $emailTemplate->getMemoEn(),
            'memo_jp' => $emailTemplate->getMemoJp()
        ]);

        return $emailTemplate->getEmailTemplateId();
    }

    /**
     * @param EmailTemplateId $emailTemplateId
     * @return bool
     */
    public function deleteEmailTemplate(EmailTemplateId $emailTemplateId): bool
    {
        $entity = ModelEmailTemplate::findOrFail($emailTemplateId->getValue());
        $entity->delete();
        return true;
    }
}
