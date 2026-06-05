<?php

namespace App\DTO\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ToArrayDTOInterface
{
    public function toArray(?Model $model = null): array;
}
