<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    // If your table name isn't "allowances"
    protected $table = 'user_allowance';

    protected $fillable = [
        'userID',
        'source',
        'amount',
        'month_year',
    ];

    // Relationship: an allowance belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
