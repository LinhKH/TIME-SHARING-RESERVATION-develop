<?php
declare(strict_types=1);

namespace App\Bundle\Common\Test\Application;

use App\Bundle\Common\Application\ITransaction;

class TestTransaction implements ITransaction
{
    /**
     * @param callable $callback callback
     * @return mixed
     */
    public function transactional(callable $callback)
    {
        return $callback();
    }
}
