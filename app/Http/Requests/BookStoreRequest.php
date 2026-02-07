<?php declare(strict_types=1);

namespace App\Http\Requests;

use App\DataTransferObjects\AuthorsIdsData;
use App\DataTransferObjects\CreateBookData;
use Illuminate\Foundation\Http\FormRequest;

final class BookStoreRequest extends FormRequest
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

    public function getData(): CreateBookData
    {
        return new CreateBookData(
            title: $this->validated('title'),
            authors: new AuthorsIdsData($this->validated('authors'))
        );
    }
}
