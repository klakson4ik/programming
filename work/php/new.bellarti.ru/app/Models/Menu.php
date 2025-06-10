<?php

namespace App\Models;

class Menu extends BaseModel
{
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    protected $fillable = [
        'parent_id',
        'name',
        'code',
        'active'
    ];

    public $timestamps = false;
}
