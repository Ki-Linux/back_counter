<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Name extends Model
{
    use HasFactory;
    protected $table = "half_access_names";
    protected $fillable = [
        'account_id', 
        'front', 
    ];
}
