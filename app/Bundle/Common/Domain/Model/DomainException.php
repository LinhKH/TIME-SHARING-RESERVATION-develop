<?php
namespace App\Bundle\Common\Domain\Model;

use Exception;

abstract class DomainException extends Exception
{
    /**
     * @var int
     */
    protected $errorCode = 0;

    /**
     * @var string
     */
    protected $errorTitle = '';

    /**
     * @param string $message message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, $this->errorCode);
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return [
            [
                'code' => (string)$this->errorCode,
                'title' => $this->message ?? $this->errorTitle,
            ],
        ];
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->errorCode;
    }
}
