<?php
namespace  App\Bundle\Common\Constants;

final class MessageConst
{
    public const REQUIRE_DATA = [
        'title' => 'require_data',
        'message' => '必須項目です'
    ];

    public const NO_RECORD = [
        'title' => 'no_record',
        'message' => 'データがなし',
    ];

    public const NOT_FOUND = [
        'title' => 'not_found',
        'message' => 'レコードが存在していません',
    ];

    public const EXISTING_EMAIL = [
        'title' => 'existing_email',
        'message' => 'メールは存在していました。',
    ];
}
