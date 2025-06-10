<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vacancy extends BaseModel
{
    use HasFactory;

	protected $table = 'vacancies';
	protected $fillable = ['lang', 'sort', 'active', 'title', 'url_slug', 'city', 'publish_at', 'description'];

}
