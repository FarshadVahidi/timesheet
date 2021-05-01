<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function azienda()
    {
        $this->belongsTo(Azienda::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
