<?php declare(strict_types=1);

namespace App\DataTransferObjects;

final readonly class UpdateBookData
{
    public function __construct(
        public string $title,
        public ?AuthorsIdsData $authors = null
    ){}
}
