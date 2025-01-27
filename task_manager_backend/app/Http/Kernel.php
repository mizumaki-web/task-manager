<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * グローバルミドルウェアの登録
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\Cors::class, // Corsミドルウェアを登録
        // 他のミドルウェアを追加可能
    ];

    /**
     * ルートミドルウェアの登録
     *
     * @var array
     */
    protected $routeMiddleware = [
        'cors' => \App\Http\Middleware\Cors::class, // Corsミドルウェアを登録
        // 他のルートミドルウェアを追加可能
    ];
}
