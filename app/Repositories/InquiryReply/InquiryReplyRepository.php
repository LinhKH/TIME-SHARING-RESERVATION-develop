<?php

namespace App\Repositories\InquiryReply;

use App\Models\Inquiry;
use App\Models\InquiryReply;
use App\Repositories\AbstractBaseRepository;

class InquiryReplyRepository extends AbstractBaseRepository implements InquiryReplyInterface
{
    public function __construct(InquiryReply $model)
    {
        parent::__construct($model);
    }


    public function getListReply($id)
    {
        return InquiryReply::leftJoin('users', 'users.id', 'inquiry_reply.user_id')
            ->leftJoin('customer', 'customer.id', 'inquiry_reply.customer_id')
            ->select(
                'inquiry_reply.description',
                'inquiry_reply.creation_time',
                'customer.first_name as customer_first_name',
                'customer.id as customer_id',
                'customer.last_name as customer_last_name',
                'users.first_name',
                'users.last_name',
                'users.id as user_id',
                'inquiry_reply.created_at',
            )
            ->where('inquiry_reply.inquiry_id', $id)
            ->orderBy('inquiry_reply.created_at', 'ASC')
            ->get()->toArray();
    }

    public function handleCheckInquirySpace($spaceId)
    {
        return Inquiry::where('rental_space_id', $spaceId)->where('inquiry_typeWF', 'space')->whereNull('user_id')->whereNull('customer_id')->first();
    }

    /**
     * @param int $replyId
     *
     * @return array
     */
    public function getListReplySpace(int $replyId): array
    {
        $sql = InquiryReply::where('inquiry_id', $replyId)->with('user');

        return $sql->get()->toArray();
    }
}
