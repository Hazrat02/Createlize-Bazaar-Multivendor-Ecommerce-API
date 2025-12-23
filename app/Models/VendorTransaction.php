<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_profile_id',
        'amount',
        'type',
        'payment_method',
        'reference',
        'account_info',
        'note',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'account_info' => 'array',
    ];

    public function vendorProfile()
    {
        return $this->belongsTo(VendorProfile::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
