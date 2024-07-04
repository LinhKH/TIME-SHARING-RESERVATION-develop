<?php
namespace App\Bundle\UserBundle\Application;

final class UserManageGetCommand
{
    /**
     * @var int
     */
    public int $userId;

    /**
     * @param int $userId userId
     */
    public function __construct(int $userId){
        $this->userId = $userId;
    }
}
