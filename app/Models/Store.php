<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function types()
    {
        return $this->belongsTo(Type::class,'type_id');
    }

}
