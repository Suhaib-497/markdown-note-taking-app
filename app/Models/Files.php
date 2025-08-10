<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class files extends Model
{
    protected $fillable = [

        'note_id',
        'file_path',

    ];


    public function note()
    {
        return $this->belongsTo(Notes::class, 'note_id');
    }
}
