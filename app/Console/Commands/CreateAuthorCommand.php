<?php declare(strict_types=1);

namespace App\Console\Commands;

use App\DataTransferObjects\CreateAuthorData;
use App\Services\AuthorService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

final class CreateAuthorCommand extends Command
{
    protected $signature = 'create:author {--first=} {--last=}';
    protected $description = 'Create an author';

    public function handle(AuthorService $authorService): int
    {
        $input = [
            'first' => trim((string) ($this->option('first') ?? '')),
            'last' => trim((string) ($this->option('last') ?? '')),
        ];

        if ($input['first'] === '') {
            $input['first'] = trim((string) $this->ask('What is the first name of the author?'));
        }

        if ($input['last'] === '') {
            $input['last'] = trim((string) $this->ask('What is the last name of the author?'));
        }

        $validator = Validator::make($input, [
            'first' => 'required|string|max:255',
            'last' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $data = $validator->validated();
        $name = $data['first'].' '.$data['last'];

        $author = $authorService->createAuthor(new CreateAuthorData($name));

        $this->info("Author created (id={$author->getKey()}): {$author->name}");

        return self::SUCCESS;
    }
}
