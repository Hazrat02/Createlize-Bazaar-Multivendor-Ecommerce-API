<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug','is_active','sort_order','image_path','icon_path'];

    protected $casts = ['is_active'=>'boolean'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
