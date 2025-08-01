<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $method = $this->method();

        if ($method === 'PUT') {
            return [
                'name' => ['required', 'string', 'max:255'],
                'slug' => ['nullable', 'string', 'max:255', 'unique:categories'],
                'description' => ['nullable', 'string'],
                'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
                'image' => ['nullable', 'image', 'mimes:jpg,png', 'max:2048'],
            ];
        } else {
            return [
                'name' => ['sometimes', 'string', 'max:255'],
                'slug' => ['nullable', 'string', 'max:255', 'unique:categories'],
                'description' => ['nullable', 'string'],
                'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
                'image' => ['nullable', 'image', 'mimes:jpg,png', 'max:2048'],
            ];
        }
    }
}
