<?php

namespace App\Models\Pages;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CerfificatePage extends BaseModel
{
    use HasFactory;

	protected $table = 'certificate_page';

	protected $casts = [
		'data' => 'json',
	];
}
