<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceGetPageAndEmailMessageAllInformation
{
    private ?PageAndEmailId $id;
    private ?string $title;
    private ?string $content;
    private ?PageAndEmailMessageType $type;

    /**
     * @param PageAndEmailId|null $id
     * @param string|null $title
     * @param string|null $content
     * @param PageAndEmailMessageType|null $type
     */
    public function __construct(
        ?PageAndEmailId $id,
        ?string $title,
        ?string $content,
        ?PageAndEmailMessageType $type
    ){
        $this->content = $content;
        $this->title = $title;
        $this->id = $id;
        $this->type = $type;
    }

    /**
     * @return PageAndEmailId|null
     */
    public function getId(): ?PageAndEmailId
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return PageAndEmailMessageType|null
     */
    public function getType(): ?PageAndEmailMessageType
    {
        return $this->type;
    }

}
