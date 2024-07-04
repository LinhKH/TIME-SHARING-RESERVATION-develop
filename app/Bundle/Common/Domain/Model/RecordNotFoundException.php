<?php
namespace App\Bundle\Common\Domain\Model;

class RecordNotFoundException extends DomainException
{
    protected $errorCode = 101;
    protected $errorTitle = '該当レコードが存在しません。';
}
