<?php declare(strict_types=1);

namespace App\Jobs;

use App\DataTransferObjects\AuthorsIdsData;
use App\Models\Author;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

final class SaveLastBookTitleJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly AuthorsIdsData $authorsIds,
        private readonly string $lastBookTitle
    ){}

    public function handle(): void
    {
        Author::query()
            ->whereIn('id', $this->authorsIds->toArray())
            ->update(['last_book_title' => $this->lastBookTitle]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Save last book title job failed', [
            'message' => $exception->getMessage(),
            'exception' => $exception
        ]);
    }
}
