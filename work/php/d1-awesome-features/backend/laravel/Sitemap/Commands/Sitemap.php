<?php

namespace App\Console\Commands;

use App\Services\SitemapService\Base;
use Illuminate\Console\Command;

class Sitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make sitemap';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$sitemapService = new Base();
		$sitemapService->make();
    }
}
