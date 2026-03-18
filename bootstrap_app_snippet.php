<?php
// Dans bootstrap/app.php — ajouter le middleware admin :
use App\Http\Middleware\AdminMiddleware;

->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => AdminMiddleware::class,
    ]);
})
