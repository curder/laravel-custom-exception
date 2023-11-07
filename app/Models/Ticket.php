<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price', 'quantity',
    ];

    public function isAvailable(int $quantity): bool
    {
        return $this->quantity >= $quantity;
    }
}
