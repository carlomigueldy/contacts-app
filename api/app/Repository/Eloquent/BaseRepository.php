<?php

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get(): Collection
    {
        return $this->model->get();
    }

    public function findById(int $modelId): ?Model
    {
        return $this->model->findOrFail($modelId);
    }
}
