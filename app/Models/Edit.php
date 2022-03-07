<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edit extends Model
{
    use HasFactory;
    protected $table = "edits";
    protected $fillable = [
        'username', 
        'picture', 
        'my_comment', 
        'can_good', 
        'can_comment', 
        'can_see',
        'can_top',
        'can_list'
    ];
}
