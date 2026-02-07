<?php declare(strict_types=1);

namespace App\DataTransferObjects;

final readonly class CreateAuthorData
{
    public function __construct(
        public string $name
    ){}
}
