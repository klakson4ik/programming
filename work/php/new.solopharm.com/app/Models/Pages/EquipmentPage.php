<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class EquipmentPage extends BaseModel
{
	use HasFactory;

	protected $table = 'equipment_page';

	protected $casts = [];
}
