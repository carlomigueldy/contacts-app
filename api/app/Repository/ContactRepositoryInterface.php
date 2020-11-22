<?php

namespace App\Repository;

interface ContactRepositoryInterface extends EloquentRepositoryInterface
{
    /**
     * @param string $path
     */
    public function import(string $path): bool;
}
