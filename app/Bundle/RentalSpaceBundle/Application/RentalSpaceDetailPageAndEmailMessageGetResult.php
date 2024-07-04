<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceDetailPageAndEmailMessageGetResult
{
    /**
     * @var int
     */
    public int $pageAndEmailId;

    /**
     * @var string|null
     */
    public ?string $title;

    /**
     * @var string|null
     */
    public ?string $content;

    /**
     * @var string|null
     */
    public ?string $type;

    /**
     * RentalSpaceDetailPageAndEmailMessageGetResult constructor.
     * @param int $pageAndEmailId
     * @param string|null $title
     * @param string|null $content
     * @param string|null $type
     */

    public function __construct(int $pageAndEmailId, ?string $title, ?string $content, ?string $type)
    {
        $this->pageAndEmailId = $pageAndEmailId;
        $this->title = $title;
        $this->content = $content;
        $this->type = $type;
    }
}
