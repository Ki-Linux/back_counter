<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    protected $table = "reports";
    protected $fillable = [
        'username',
        'user_id',
        'good_or_comment',
        'can_report',
    ];
}
