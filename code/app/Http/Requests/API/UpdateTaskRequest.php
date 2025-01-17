<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:pending,completed,cancelled',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
            'due_date' => 'nullable|date|date_format:Y-m-d|after_or_equal:today',
        ];
    }
}
