<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResumeTemplate extends Model
{
    protected $fillable = ['name', 'html', 'created_by', 'is_default'];

    protected $casts = ['is_default' => 'boolean'];
}
