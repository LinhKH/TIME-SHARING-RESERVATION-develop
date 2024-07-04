<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpacePutEmailMessageCommand
{
    /**
     * @var int
     */
    public int $emailMessageId;

    /**
     * @var string
     */
    public string $content;

    /**
     * RentalSpacePutEmailMessageCommand constructor.
     * @param int $emailMessageId
     * @param string $content
     */
    public function __construct(int $emailMessageId, string $content)
    {
        $this->emailMessageId = $emailMessageId;
        $this->content = $content;
    }
}
