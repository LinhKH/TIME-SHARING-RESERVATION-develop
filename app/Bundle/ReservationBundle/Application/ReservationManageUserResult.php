<?php

namespace App\Bundle\ReservationBundle\Application;

final class ReservationManageUserResult
{
    public int $id;
    public string $firstName;
    public string $lastName;

    /**
     * @param int $id
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(
        int $id,
        string $firstName,
        string $lastName
    ){
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->id = $id;
    }
}
