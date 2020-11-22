<?php

namespace App\Repository;

interface ContactRepositoryInterface extends EloquentRepositoryInterface
{
    public function import($path);
}
