<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryType extends Model
{
    use HasFactory;

    protected $fillable = ['name','key','description','is_active','sort_order'];

    protected $casts = ['is_active'=>'boolean'];

    public function fields()
    {
        return $this->hasMany(DeliveryField::class)->orderBy('sort_order');
    }
}
