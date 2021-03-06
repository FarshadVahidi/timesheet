<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Azienda extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = "aziende";

    public function orders()
    {
        $this->hasMany(Order::class);
    }
}
