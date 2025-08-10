<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notes extends Model
{
    protected $fillable=[
        'markdown_text'
    ];


    public function files(){
        return $this->hasMany(Files::class,'note_id');
    }
}
