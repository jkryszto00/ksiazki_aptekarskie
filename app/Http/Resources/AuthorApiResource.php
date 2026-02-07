<?php declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Author */
final class AuthorApiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getKey(),
            'name' => $this->name,
            'books' => $this->whenLoaded('books', BookApiResource::collection($this->books)),
            'created_at' => $this->created_at->toDateTimeString()
        ];
    }
}
