<?php
namespace App\Bundle\Common\Domain\Model;

class AccessDenyException extends DomainException
{
    protected $errorCode = 403;
    protected $errorTitle = 'この画面にアクセス権限がありません';
}
