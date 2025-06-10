<?php

namespace App\Models\Pages;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryPage extends BaseModel
{
    use HasFactory;

	protected $table = 'gallery_page';

	protected $casts = [
		'data' => 'json',
	];
}
