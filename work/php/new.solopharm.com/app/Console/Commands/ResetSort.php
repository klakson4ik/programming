<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetSort extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:reset-sort {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset sorting in table BD';
    const NAME_FIELD = 'sort';
    const DEFAULT_SORT = 500;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $model = 'App\\Models\\' . $this->argument('model');
        if(class_exists($model)) {
            $this->resetSort($model);
        } else {
            echo 'Класс ' . $model. ' не существует' . PHP_EOL;
        }

    }

    private function resetSort(string $model): void
    {
        $data = $model::where(self::NAME_FIELD, '!=', self::DEFAULT_SORT)->get();
        foreach ($data as $item) {
                $item->update(
                    [
                        self::NAME_FIELD => self::DEFAULT_SORT
                    ]
                );
        }
    }
}
