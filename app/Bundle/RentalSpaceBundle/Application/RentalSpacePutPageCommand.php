<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpacePutPageCommand
{
    /**
     * @var int
     */
    public int $pageId;

    /**
     * @var string
     */
    public string $content;

    /**
     * @var string
     */
    public ?string $title;

    /**
     * RentalSpacePutPageCommand constructor.
     * @param int $pageId
     * @param string $content
     * @param ?string $title
     */
    public function __construct(int $pageId, string $content, ?string $title)
    {
        $this->pageId = $pageId;
        $this->content = $content;
        $this->title = $title;
    }
}
