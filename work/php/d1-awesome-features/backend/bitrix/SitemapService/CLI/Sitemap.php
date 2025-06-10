<?php
namespace App\CLI;

use App\Services\Sitemap\Base as ServiceSitemap;

class Sitemap extends \TAO\CLI
{
	public function build_sitemap()
	{
		$sitemap = new ServiceSitemap();
		$sitemap->make();
	}
}
