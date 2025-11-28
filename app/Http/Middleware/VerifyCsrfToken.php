<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'http://localhost:8000/post_cronjobs_loker',
        'medical-record/*',  // exclude all URLs wit payment/ prefix
        'master/*', // exclude exact URL
        'user/*',  // exclude all URLs wit payment/ prefix
        'login',
    ];
}
