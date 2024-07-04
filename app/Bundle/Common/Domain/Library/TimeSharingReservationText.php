<?php

namespace App\Bundle\Common\Domain\Library;

use Ulid\Ulid;

final class TimeSharingReservationText
{
    /**
     * @return string
     */
    public static function id(): string
    {
        return (string)Ulid::generate();
    }
}

