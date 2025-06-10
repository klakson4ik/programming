<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPublication extends BaseModel
{
    protected $table = 'product_publications';
    protected $primaryKey = 'id';

    public $timestamps = false;
}