<?php
declare(strict_types=1);

namespace App\Bundle\Common\Infrastructure;

use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\Common\Application\ITransaction;

class Transaction implements ITransaction
{
    /**
     * @inheritDoc
     */
    public function transactional(callable $callback)
    {
        try {
            \DB::transaction($callback);
        } catch (\Exception $e) {
            \Log::error($e);
            throw new TransactionException('更新できませんでした');
        }
    }
}
