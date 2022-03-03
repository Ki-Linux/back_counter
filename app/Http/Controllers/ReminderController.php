<?php

namespace App\Http\Controllers;

use App\Models\Reminder;

use Illuminate\Http\Request;

class ReminderController extends Controller
{
    //
    public function index() 
    {
        $reminder = new Reminder();

        $reminder->create([
            'content' => 'ui',
        ]);
    }
}
