<?php

namespace App\Models;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function car()
    {
        return $this->hasOne(Car::class);
    }
}
