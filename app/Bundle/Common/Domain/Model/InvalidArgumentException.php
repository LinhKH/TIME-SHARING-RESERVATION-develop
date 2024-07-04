<?php
namespace App\Bundle\Common\Domain\Model;

class InvalidArgumentException extends DomainException
{
    protected $errorCode = 100;
    protected $errorTitle = '不正な引数です。';

    /**
     * @param string $message message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
        $this->errorTitle = $message;
    }
}
