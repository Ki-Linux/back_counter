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
        'api/reminder_send',
        'api/delete_reminder/*',
        'api/update_reminder/*',
        'api/edit',
        'api/edit_show',
        'api/edit_del/*',
        'api/edit_update/*',
        'api/pull_all',
        'api/only_top',
        'api/account',
        'api/account_update/*',
        'api/album_data',
        'api/my_album_data_get',
        'api/delete_album_data/*',
        'api/get_comment',
    ];

   
}
