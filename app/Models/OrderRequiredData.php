<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRequiredData extends Model
{
    use HasFactory;

    protected $table = 'order_required_data';

    protected $fillable = ['order_id','field_title','field_name','field_type','value','file_path'];

    public function order() { return $this->belongsTo(Order::class); }
}
