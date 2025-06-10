<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indexing extends Model
{
    protected $table = 'indexing';

    protected $casts = [
        'founds' => 'json'
    ];
}
