<?php declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\CreateAuthorData;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;

final class AuthorService
{
    public function searchByBookTitle(string $search = null, int $limit = 10): LengthAwarePaginator
    {
        return Author::query()
            ->with('books')
            ->whereHas('books', fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->paginate ($limit);
    }

    public function getAuthorWithBooks(Author $author): Author
    {
        return $author->load('books');
    }

    public function createAuthor(CreateAuthorData $createAuthorData): Author
    {
        return Author::create(['name' => $createAuthorData->name]);
    }
}
