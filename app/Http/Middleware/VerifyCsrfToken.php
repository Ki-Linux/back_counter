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
        'api/check_change_password',
        'api/check_change_password/*',
        'api/get_information',
        'api/get_id',
        'api/logout/*',
        'api/confirm_token',
        'api/post_reminder_update/*',
        'api/mail',
        'api/reminder',
        'api/reminder_send',
        'api/delete_reminder/*',
        'api/update_reminder/*',
        'api/edit',
        'api/edit_show',
        'api/edit_del/*',
        'api/edit_update',
        'api/pull_all',
        'api/only_top',
        'api/account',
        'api/account_update/*',
        'api/album_data',
        'api/my_album_data_get',
        'api/delete_album_data/*',
        'api/get_comment',
        'api/get_img_good_comment',
        'api/details_good_more/*',
        'api/add_comment_data',
        'api/get_comment_data',
        'api/comment_delete/*',
        'api/comment_report',
        'api/sendContactMail',
        'api/img_account_post',
        'api/counter_image',
        'api/storage_counter_delete',
    ];

   
}
