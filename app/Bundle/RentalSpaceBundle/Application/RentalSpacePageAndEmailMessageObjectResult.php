<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePageAndEmailMessageObjectResult
{
    public int $id;
    public string $title;
    public string $content;

    /**
     * @param int $id
     * @param string $title
     * @param string $content
     */
    public function __construct(
        int $id,
        string $title,
        string $content
    ){
        $this->content = $content;
        $this->title = $title;
        $this->id = $id;
    }
}
