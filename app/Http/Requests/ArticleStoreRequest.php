<?php

namespace App\Http\Requests;

use App\Enums\ApiSources;
use App\Enums\HttpResponseCode;
use App\Exceptions\RequestValidatorException;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ArticleStoreRequest extends FormRequest
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
            'url' => 'required|url|max:280',
            'title' => 'required|string|max:255',
            'api_source' => [
                'required',
                Rule::in(array_column(ApiSources::cases(), 'value')),
            ],
            'source' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:50',
            'language' => 'nullable|string|max:50',
            'url_to_image' => 'nullable|string|max:280',
            'content' => 'nullable|string',
            'published_at' => 'required|date',
        ];
    }


    /**
     * Sanitize input data before validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'url' => $this->sanitize($this->input('url')),
            'title' => $this->sanitize($this->input('title')),
            'api_source' => $this->sanitize($this->input('api_source')),
            'source' => $this->sanitize($this->input('source')),
            'author' => $this->sanitize($this->input('author')),
            'description' => $this->sanitize($this->input('description')),
            'category' => $this->sanitize($this->input('category')),
            'language' => $this->sanitize($this->input('language')),
            'url_to_image' => $this->sanitize($this->input('url_to_image')),
            'content' => $this->sanitize($this->input('content')),
            'published_at' => $this->sanitize($this->input('published_at')),
        ]);
    }

    /**
     * Basic sanitization to prevent harmful input.
     */
    private function sanitize($value): ?string
    {
        return $value ? mb_convert_encoding(htmlspecialchars(strip_tags(trim($value))), 'UTF-8', 'UTF-8') : null;
    }


    public function failedValidation(Validator $validator)
    {
        throw new RequestValidatorException(response()->json([
            'success' => false,
            'message' => $validator->errors(),
            'data' => $validator->errors()
        ], HttpResponseCode::FORBIDDEN->value));
    }
}
