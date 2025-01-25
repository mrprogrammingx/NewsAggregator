<?php

namespace App\Http\Requests;

use App\Enums\ApiSources;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
            'url' => 'required|url|max:255',
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
            'url_to_image' => 'nullable|string|max:255', 
            'content' => 'nullable|string', 
            'published_at' => 'required|date', 
        ];
    }
}
