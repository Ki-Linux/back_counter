<?php

namespace App\Http\Controllers;

use App\Models\Reminder;

use Illuminate\Http\Request;
use \Symfony\Component\HttpFoundation\Response;

class ReminderController extends Controller
{
    //
    public function index(Response $request) 
    {
        $reminder = new Reminder();

        $reminder->create([
            'content' => 'ii',
        ]);
    }
}
