<?php

namespace App\Repositories;

use App\Models\Sample;
use App\Repositories\Contracts\BaseRepository;
use App\Repositories\Contracts\SampleRepositoryInterface;

class SampleRepository extends BaseRepository implements SampleRepositoryInterface
{
    public function __construct(Sample $model)
    {
        parent::__construct($model);
    }
}
