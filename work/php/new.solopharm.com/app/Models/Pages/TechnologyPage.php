<?php

namespace App\Models\Pages;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TechnologyPage extends BaseModel
{
    use HasFactory;

	protected $table = 'technology_page';

	protected $casts = [
	];
}
