<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attend extends Model
{
    use HasFactory;

    protected $fillable=['user_id','work_start','work_end','created_at','updated_at'];
    public $timestamps = false; // 追加
}
