<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailVerifController;
use App\Http\Controllers\GalangdanaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('newHome');
});

Route::get('/command', function() {
    Artisan::command('config:cache');
});


Route::get('email/verification', [EmailVerifController::class, 'verifEmail']);

Route::view('/readme', 'readme');

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle']);

Auth::routes(['verify' => true]);

Route::view('donation', 'snap.donation');

// will be execute when the photo doesnot found in public/images/images_campaign
Route::get('/images/images_campaign/{filename}', function($filename) {
    $path = Storage::path('images/images_campaign/'.$filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});

Route::get('/email', function () {
   return view('emails.campaigncreated');
});
