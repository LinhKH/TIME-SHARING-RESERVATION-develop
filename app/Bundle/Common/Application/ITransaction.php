<?php
declare(strict_types=1);

namespace App\Bundle\Common\Application;

interface ITransaction
{
    /**
     * @param callable $callback callback
     * @return mixed
     */
    public function transactional(callable $callback);
}
