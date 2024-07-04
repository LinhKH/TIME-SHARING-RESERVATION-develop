<?php

namespace App\Repositories\InquiryReply;

use App\Repositories\RepositoryInterface;

interface InquiryReplyInterface extends RepositoryInterface
{
    public function getListReply($id);
}
