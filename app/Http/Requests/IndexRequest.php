<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function validationData(): array
    {
        return $this->query();
    }

    public function rules(): array
    {
        return [
            'search' => 'sometimes|string|max:255',
            'per_page' => 'sometimes|integer|min:1|max:100'
        ];
    }

    public function perPage(): int
    {
        return (int) $this->validated('per_page', 10);
    }

    public function searchQuery(): ?string
    {
        $value = $this->validated('search');
        $value = $value === null ? null : trim((string) $value);

        return $value === '' ? null : $value;
    }
}
