<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'amount',
        'description',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
