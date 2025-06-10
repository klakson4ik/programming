<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class NewsPage extends BaseModel
{
	use HasFactory;

	protected $table = 'news_page';
}
