<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Todo;

use Illuminate\Foundation\Http\FormRequest;

final class StoreTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'tiltle' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
