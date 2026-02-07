<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'last_book_title'
    ];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'author_book')->withTimestamps();
    }
}
