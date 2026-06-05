<?php

namespace App\DTO\Contracts;

use Illuminate\Foundation\Http\FormRequest;

interface FromRequestDTOInterface
{
    public static function fromRequest(FormRequest $request): static;
}
