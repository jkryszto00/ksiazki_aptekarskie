<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexRequest;
use App\Http\Resources\AuthorApiResource;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class AuthorController extends Controller
{
    public function __construct(
        private readonly AuthorService $authorService
    ){}

    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $authors = $this->authorService->searchByBookTitle(
            search: $request->searchQuery(),
            limit: $request->perPage()
        );

        return AuthorApiResource::collection($authors);
    }

    public function show(Author $author): AuthorApiResource
    {
        $author = $this->authorService->getAuthorWithBooks($author);

        return AuthorApiResource::make($author);
    }
}
