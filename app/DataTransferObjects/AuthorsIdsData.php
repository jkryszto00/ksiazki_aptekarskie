<?php declare(strict_types=1);

namespace App\DataTransferObjects;

use App\Exceptions\InvalidDataException;

final class AuthorsIdsData
{
    public function __construct(
        public array $ids
    ){
        if (empty($ids)) {
            throw new InvalidDataException('Authors ids cannot be empty');
        }

        foreach ($ids as $id) {
            if (!is_int($id) || $id <= 0) {
                throw new InvalidDataException('Authors ids must be positive number');
            }
        }

        $this->ids = array_values(array_unique($ids));
        sort($this->ids);
    }

    public function toArray(): array
    {
        return $this->ids;
    }
}
