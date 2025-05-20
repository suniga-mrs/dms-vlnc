<?php 

namespace App\Infrastructure\Shared;

use Illuminate\Support\Facades\DB;
use Throwable;
use App\Domain\Shared\UnitOfWorkInterface;

// TODO: Update so that we can use multiple 
// DB connections to separate the table where event records are persisted
class DatabaseUnitOfWork implements UnitOfWorkInterface
{
    protected bool $inTransaction = false;

    public function begin(): void
    {
        if (!$this->inTransaction) {
            DB::beginTransaction();
            $this->inTransaction = true;
        }
    }

    public function commit(): void
    {
        if ($this->inTransaction) {
            DB::commit();
            $this->inTransaction = false;
        }
    }

    public function rollback(): void
    {
        if ($this->inTransaction) {
            DB::rollBack();
            $this->inTransaction = false;
        }
    }

    public function execute(callable $callback)
    {
        $this->begin();

        try {
            $result = $callback();
            $this->commit();
            return $result;
        } catch (Throwable $e) {
            $this->rollback();
            throw $e;
        }
    }
}
