<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\ApiSources;
use Illuminate\Validation\Rule;

class ArticleSearchRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:255',
            'category' => 'nullable|string|in:General,Sports,Entertainment,Technology', // Update with valid categories
            'source' => 'nullable|string|max:100',
            'api_source' => [
                'nullable',
                Rule::in(array_column(ApiSources::cases(), 'value')),
            ],
            'author' => 'nullable|string|max:100',
            'date_from' => 'nullable|date|before_or_equal:date_to',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'per_page' => 'nullable|integer',
        ];
    }

    /**
     * Sanitize input data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'search' => $this->sanitize($this->input('search')),
            'category' => $this->sanitize($this->input('category')),
            'source' => $this->sanitize($this->input('source')),
            'author' => $this->sanitize($this->input('author')),
            'per_page' => $this->sanitize($this->input('per_page')),
        ]);
    }

    /**
     * Basic sanitization to prevent harmful input.
     */
    private function sanitize($value): ?string
    {
        return $value ? htmlspecialchars(strip_tags(trim($value))) : null;
    }
}
