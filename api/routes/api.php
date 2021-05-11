<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\ExampleController;
use App\Http\Controllers\Api\V1\User\Service\UserController;
use Illuminate\Routing\RouteFileRegistrar;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/** @var RouteFileRegistrar $this */

$router = $this->router;

$router->post('/v1/example/test', [ExampleController::class, 'test']);
$router->get('/v1/user/service/view', [UserController::class, 'view']);
$router->post('/v1/user/service/create', [UserController::class, 'create']);
