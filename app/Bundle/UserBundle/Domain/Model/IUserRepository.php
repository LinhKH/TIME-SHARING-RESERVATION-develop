<?php
namespace App\Bundle\UserBundle\Domain\Model;

interface IUserRepository
{
    /**
     * @param \App\Bundle\UserBundle\Domain\Model\User $user user
     * @return \App\Bundle\UserBundle\Domain\Model\UserId
     */
    public function createUser(User $user): UserId;

    /**
     * @param \App\Bundle\UserBundle\Domain\Model\UserId $userId userId
     * @return bool
     */
    public function remove(UserId $userId): bool;

    /**
     * @param \App\Bundle\UserBundle\Domain\Model\UserId $userId userId
     * @return \App\Bundle\UserBundle\Domain\Model\User
     */
    public function findById(UserId $userId): ?User;

    /**
     * no param
     * @return array{\App\Bundle\UserBundle\Domain\Model\User[], \App\Bundle\UserBundle\Domain\Model\Pagination}
     */
    public function findAll(): array;

    /**
     * @param \App\Bundle\UserBundle\Domain\Model\User $user user
     * @return \App\Bundle\UserBundle\Domain\Model\UserId
     */
    public function updateUser(User $user): UserId;
}
