<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function get(): Collection;

    public function findById(int $modelId): ?Model;

    public function create(array $payload): ?Model;

    public function updateById(int $modelId, array $payload): bool;
}
