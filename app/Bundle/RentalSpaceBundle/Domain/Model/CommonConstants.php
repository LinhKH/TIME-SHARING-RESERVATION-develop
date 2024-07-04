<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;


final class CommonConstants
{
    const WEEKDAY_MAP = [
        "All" => 'all',
        'Mon' => 'day.monday',
        'Tue' => 'day.tuesday',
        'Wed' => 'day.wednesday',
        'Thu' => 'day.thursday',
        'Fri' => 'day.friday',
        'Sat' => 'day.saturday',
        'Sun' => 'day.sunday',
    ];

}
