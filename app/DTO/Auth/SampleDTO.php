<?php

namespace App\DTO\Auth;

use Illuminate\Database\Eloquent\Model;
use App\DTO\Contracts\ToArrayDTOInterface;
use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Contracts\FromRequestDTOInterface;

class SampleDTO implements FromRequestDTOInterface, ToArrayDTOInterface
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @param string|null $email
     */
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly ?string $email = null,
    ) {
    }

    /**
     * @param FormRequest $request
     *
     * @return static
     */
    public static function fromRequest(FormRequest $request): static
    {
        return new static(
            firstName: $request->input('first_name'),
            lastName: $request->input('last_name'),
            email: $request->input('email'),
        );
    }

    /**
     * @param Model|null $model
     *
     * @return array
     */
    public function toArray(?Model $model = null): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
        ];
    }
}
