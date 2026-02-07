<?php declare(strict_types=1);

namespace App\DataTransferObjects;

final readonly class CreateBookData
{
    public function __construct(
        public string $title,
        public AuthorsIdsData $authors
    ){}
}
