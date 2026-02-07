<?php declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Book */
final class BookApiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->title,
            'authors' => $this->whenLoaded('authors', AuthorApiResource::collection($this->authors)),
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
