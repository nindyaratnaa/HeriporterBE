<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Middleware\ApiAuthMiddleware;

// Handle OPTIONS preflight
Route::options('/{any}', fn() => response('', 204))->where('any', '.*');

// Public
Route::post('/auth/login',    [ApiController::class, 'login']);
Route::post('/auth/register', [ApiController::class, 'register']);

// Sorting Hat (public - pakai token tapi tidak wajib login penuh)
Route::get('/sorting-hat/questions',  [ApiController::class, 'sortingHatQuestions']);
Route::middleware(ApiAuthMiddleware::class)->post('/sorting-hat/assign', [ApiController::class, 'sortingHatAssign']);

// Protected
Route::middleware(ApiAuthMiddleware::class)->group(function () {

    // Auth [Khaula]
    // keduanya
    Route::get('/auth/me', [ApiController::class, 'me']);

    //Users [Khaula]
    //guru only
    Route::get('/users',                           [ApiController::class, 'users']);
    Route::get('/users/{student_name}',            [ApiController::class, 'userShow']);

    //Profile [Khaula]
    //student only
    Route::post('/profile/photo',                  [ApiController::class, 'uploadPhoto']);
    Route::delete('/account',                      [ApiController::class, 'deleteAccount']);

    //Wand
    Route::get('/wands/{wand_id}',                 [ApiController::class, 'wandShow']);

    //Potions [Nya]
    //keduanya
    Route::get('/potions',                         [ApiController::class, 'potions']);
    Route::get('/potions/{potion_name}',           [ApiController::class, 'potionShow']);

    //student only
    Route::post('/potions',                        [ApiController::class, 'potionStore']);
    Route::delete('/potions/{potion_name}',        [ApiController::class, 'potionDestroy']);

    //guru only
    Route::post('/potions/{potion_name}/validate', [ApiController::class, 'potionValidate']);

    //Inventory [Sefina]
    //student only
    Route::get('/inventory',                       [ApiController::class, 'inventory']);
    Route::delete('/inventory/{potion_name}',      [ApiController::class, 'inventoryDestroy']);

    //Rapor [Adzkia]
    //keduanya
    Route::get('/rapor',                           [ApiController::class, 'rapor']);

    //student only
    Route::get('/rapor/{semester}',                [ApiController::class, 'raporShow']);

    //guru only
    Route::get('/rapor/{student_name}/{semester}', [ApiController::class, 'raporByNameSemester']);
    Route::put('/rapor/{student_name}/{semester}', [ApiController::class, 'raporUpdate']);
    Route::patch('/rapor/{student_name}/{semester}',[ApiController::class, 'raporPatch']);
});
