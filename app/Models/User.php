<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name','email','profile_image','password','status'
    ];

    protected $hidden = [
        'password','remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function vendorProfile()
    {
        return $this->hasOne(VendorProfile::class, 'user_id');
    }

    public function vendorTransactions()
    {
        return $this->hasManyThrough(VendorTransaction::class, VendorProfile::class, 'user_id', 'vendor_profile_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id');
    }

    public function ordersAsCustomer()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function ordersAsVendor()
    {
        return $this->hasMany(Order::class, 'vendor_id');
    }
}
