<?php

declare(strict_types=1);

namespace App\Console\IO;

use Symfony\Component\Console\Style\SymfonyStyle;

class InputOutput extends SymfonyStyle
{
    public function question(string $question): mixed
    {
        return $this->ask(sprintf('%s', $question));
    }

    public function right(string $message): void
    {
        $this->block(sprintf('%s', $message), null, 'fg=white;bg=green', ' ', true);
    }

    public function wrong(string $message): void
    {
        $this->block(sprintf('%s', $message), null, 'fg=white;bg=red', ' ', true);
    }

    public function message(string $message): void
    {
        $this->block(sprintf('%s', $message), null, 'fg=green;bg=black', ' ', true);
    }
}
