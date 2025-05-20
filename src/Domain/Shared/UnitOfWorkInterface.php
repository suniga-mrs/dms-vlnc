<?php

namespace App\Domain\Shared;

interface UnitOfWorkInterface
{
    public function begin(): void;
    public function commit(): void;
    public function rollback(): void;
    public function execute(callable $callback);
}