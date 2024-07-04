<?php
namespace App\Bundle\Common\Domain\Model;

class DateTimeNotFormatException extends DomainException
{
    protected $errorCode = 105;
    protected $errorTitle = '日時の値が正しい形式ではない。';
}
