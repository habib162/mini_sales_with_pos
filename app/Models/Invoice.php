<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_no',
        'from',
        'to',
        'total_amount',
        'amount_paid',
        'amount_due',
        'status' ,
    ];
}
