<?php

namespace App\Services\Forms\Interfaces;

interface StorageInterface
{
	public function store(array $fields = []);
}