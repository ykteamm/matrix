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
        'https://blackjack.novatio.uz/sms',
        'http://127.0.0.1:8000/store-news-images',
        'https://matrix.novatio.uz/store-news-images'
    ];
}
