<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingExport extends Model
{
    protected $fillable = ['resume_id', 'scrubbed_text', 'sent_to_accr'];

    protected $casts = ['sent_to_accr' => 'boolean'];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
