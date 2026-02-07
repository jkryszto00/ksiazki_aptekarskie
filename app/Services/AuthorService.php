<?php declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\CreateAuthorData;
use App\Models\Author;
use Illuminate\Pagination\LengthAwarePaginator;

final class AuthorService
{
    public function searchByBookTitle(?string $search = null, int $limit = 10): LengthAwarePaginator
    {
        return Author::query()
            ->with('books')
            ->when(
                $search,
                fn ($q, $search) => $q->whereHas('books', fn ($bq) => $bq->where('title', 'LIKE', "%{$search}%")),
            )
            ->latest()
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
