<?php declare(strict_types=1);

namespace App\Services;

use App\DataTransferObjects\AuthorsIdsData;
use App\DataTransferObjects\CreateBookData;
use App\DataTransferObjects\UpdateBookData;
use App\Jobs\SaveLastBookTitleJob;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class BookService
{
    public function getAllWithAuthors(int $limit = 10): LengthAwarePaginator
    {
        return Book::query()->with('authors')->latest()->paginate($limit);
    }

    public function getWithAuthors(Book $book): Book
    {
        return $book->load('authors');
    }

    public function create(CreateBookData $createBookData): Book
    {
        return DB::transaction(function () use ($createBookData) {
            $book = Book::create(['title' => $createBookData->title]);
            $this->syncAuthors($book, $createBookData->authors);

            SaveLastBookTitleJob::dispatch($createBookData->authors, $createBookData->title);

            return $book;
        });
    }

    public function update(Book $book, UpdateBookData $updateBookData): Book
    {
        return DB::transaction(function () use ($book, $updateBookData) {
            $book->update(['title' => $updateBookData->title]);

            if ($updateBookData->authors !== null) {
                $this->syncAuthors($book, $updateBookData->authors);
                SaveLastBookTitleJob::dispatch($updateBookData->authors, $updateBookData->title);
            }

            return $book->refresh();
        });
    }

    public function syncAuthors(Book $book, AuthorsIdsData $authorsIdsData): void
    {
        $book->authors()->sync($authorsIdsData->toArray());
    }

    public function delete(Book $book): void
    {
        $book->delete();
    }
}
