<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_name',
        'nid',
        'phone',
        'address',
        'verified_at',
        'logo_path',
        'balance',
        'payout_info',
        'documents',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'balance' => 'decimal:2',
        'payout_info' => 'array',
        'documents' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(VendorTransaction::class)->latest();
    }
}
