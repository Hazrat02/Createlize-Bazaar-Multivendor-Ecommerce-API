<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = ['provider','action','request','response','http_status'];

    protected $casts = [
        'request' => 'array',
        'response' => 'array',
        'http_status' => 'integer',
    ];
}
