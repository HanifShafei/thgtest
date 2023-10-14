<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['loan_id', 'week', 'amount', 'is_paid'];

    // Define relationship to Loan
    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
