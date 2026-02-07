<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Jobs\SaveLastBookTitleJob;
use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class BookApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_books_creates_book_and_attaches_authors_and_dispatches_job(): void
    {
        Queue::fake();

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $authors = Author::factory()->count(2)->create();

        $payload = [
            'title' => 'My New Book',
            'authors' => $authors->pluck('id')->all(),
        ];

        $response = $this->postJson('/api/books', $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', ['title' => 'My New Book']);

        $bookId = Book::query()->where('title', 'My New Book')->value('id');
        $this->assertNotNull($bookId);

        foreach ($authors as $author) {
            $this->assertDatabaseHas('author_book', [
                'author_id' => $author->getKey(),
                'book_id' => $bookId,
            ]);
        }

        Queue::assertPushed(SaveLastBookTitleJob::class);
    }

    public function test_delete_books_deletes_book(): void
    {
        $authors = Author::factory()->count(2)->create();

        $book = Book::factory()->create();
        $book->authors()->sync($authors->pluck('id')->all());

        $response = $this->deleteJson("/api/books/{$book->getKey()}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('books', ['id' => $book->getKey()]);

        foreach ($authors as $author) {
            $this->assertDatabaseMissing('author_book', [
                'author_id' => $author->getKey(),
                'book_id' => $book->getKey(),
            ]);
        }
    }
}
