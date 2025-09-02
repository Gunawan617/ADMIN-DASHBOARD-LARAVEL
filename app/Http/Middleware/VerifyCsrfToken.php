<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/analytics/*', // Exclude semua analytics endpoints dari CSRF
        'api/public/*', // Exclude public API endpoints
        // Tambahkan endpoint lain jika perlu
    ];
}
