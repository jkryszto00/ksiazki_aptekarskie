<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Requests\IndexRequest;
use App\Http\Resources\BookApiResource;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class BookController extends Controller
{
    public function __construct(
        private readonly BookService $bookService
    ){}

    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $books = $this->bookService->getAllWithAuthors(
            limit: $request->perPage()
        );

        return BookApiResource::collection($books);
    }

    public function store(BookStoreRequest $request): BookApiResource
    {
        $book = $this->bookService->create($request->getData());

        return BookApiResource::make($book)
                ->response()
                ->setStatusCode(201);
    }

    public function show(Book $book): BookApiResource
    {
        $book = $this->bookService->getWithAuthors($book);

        return BookApiResource::make($book);
    }

    public function update(BookUpdateRequest $request, Book $book): BookApiResource
    {
        $book = $this->bookService->update($book, $request->getData());

        return BookApiResource::make($book);
    }

    public function destroy(Book $book): Response
    {
        $this->bookService->delete($book);

        return response()->noContent();
    }
}
