<?php

namespace App\Repository\Eloquent;

use App\Models\Contact;
use App\Repository\ContactRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
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
