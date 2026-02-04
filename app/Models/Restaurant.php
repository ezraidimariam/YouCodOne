<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'ville',
        'capacity',
        'cuisine',
        'user_id'
    ];

    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
