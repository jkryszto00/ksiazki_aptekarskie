<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\DataTransferObjects\AuthorsIdsData;
use App\DataTransferObjects\UpdateBookData;
use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'authors' => 'required|array|min:1',
            'authors.*' => 'required|integer|exists:authors,id',
        ];
    }

    public function getData(): UpdateBookData
    {
        return new UpdateBookData(
            $this->validated('title'),
            new AuthorsIdsData($this->validated('authors'))
        );
    }
}
