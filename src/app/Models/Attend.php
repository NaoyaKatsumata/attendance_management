<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attend extends Model
{
    use HasFactory;

    protected $fillable=['user_id','work_start','work_end','break_time_start','break_time_end','break_total_time','status'];
    public $timestamps = false; // 追加
}
