<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Enums\ApiSources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author ?? 'Unknown',
            'source' => $this->source ?? 'Unknown',
            'api_source' => ApiSources::tryFrom($this->api_source)->name(),
            'category' => $this->category ?? 'General',
            'content' => $this->content ?? '',
            'description' => $this->description ?? '',
            'url_to_image' => $this->url_to_image ?? null,
            'url' => $this->url ?? null,
            'published_at' => $this->formatDate($this->published_at),
            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }

    /**
     * Format the date into a user-friendly format.
     */
    private function formatDate($date): ?string
    {
        if (!$date) {
            return null;
        }
        return Carbon::parse($date)->format('F j, Y, g:i A'); // e.g., "January 25, 2025, 5:48 PM"
    }
}
