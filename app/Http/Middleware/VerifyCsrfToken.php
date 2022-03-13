<?php

namespace App\Http\Middleware;

//use Closure;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/login',
        'api/saving',
        'api/mail',
        'api/reminder',
        'api/edit',
        'api/edit_show',
        'api/edit_del/*',
        'api/edit_update/*',
        'api/pull_all',
        'api/only_top',
    ];

   
}
