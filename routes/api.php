<?php

use App\Http\Controllers\Api\AccountVerificationController;
use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AdaYangBaruController;
use App\Http\Controllers\Api\Admin\CampaignAdminController;
use App\Http\Controllers\Api\Admin\UserAdminController;
use App\Http\Controllers\Api\Admin\ActivityAdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BankTransferController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CampaignReportController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\CriteriaController;
use App\Http\Controllers\Api\DoaDanKabarBaikController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\EMoneyController;
use App\Http\Controllers\Api\FeedController;
use App\Http\Controllers\Api\FundraiserController;
use App\Http\Controllers\Api\GoogleController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ParticipationController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\RencanaPenggunaanDanaController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\KabarTerbaruController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UrgentCampaignsController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->middleware('api')->group(function () {
    // login akun google
    Route::get('/google/callback', [AuthController::class, 'handleAuthCallbackGoogle']);

    Route::post('/register', [AuthController::class, 'registerverif']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.verify');

    Route::post('/emailverif', [AuthController::class, 'emailverif']);

    Route::get('/checkemailverif', [AuthController::class, 'cekVerifEmail']);

    Route::post('/sendemailverif', [AuthController::class, 'sendVerifEmail']);
});

// untuk login google di mobile app
Route::prefix('google')->group(function () {
    Route::post('login', [GoogleController::class, 'login']);
});

Route::get('/user/{user:username}', [UserController::class, 'show']);

Route::middleware('jwt.verify')->group(function () {
    Route::get('/user', [AuthController::class, 'getAuthenticatedUser']);
    Route::post('/user', [UserController::class, 'editProfil']);
    Route::get('/user/kode_referal', [UserController::class, 'kodeReferal']);
    Route::put('/user/change_password', [UserController::class, 'changePassword']);
    Route::get('/pekerjaan', [UserController::class, 'pekerjaan']);
    Route::get('/organisasi', [UserController::class, 'organisasi']);
    Route::get('/prov', [UserController::class, 'provinsi']);
    Route::get('/kab', [UserController::class, 'kabupaten']);
    Route::get('/kec', [UserController::class, 'kecamatan']);
});

Route::prefix('galangdana')->group(function () {
    Route::get('/', [CampaignController::class, 'index']);
    Route::get('/{campaign}', [CampaignController::class, 'show']);
    Route::get('/byslug/{campaign}', [CampaignController::class, 'bySlug']);

    // rencana penggunaan
    Route::get('/{campaign_id}/rencana_penggunaan', [RencanaPenggunaanDanaController::class, 'index']);

    // set campaign as urgent
    Route::post('/{campaign}/asurgent', [UrgentCampaignsController::class, 'add'])->middleware('jwt.verify');
    Route::post('/create', [CampaignController::class, 'create'])->middleware('jwt.verify');
    Route::post('/create/publish', [CampaignController::class, 'publish'])->middleware('jwt.verify');
    Route::post('/create/draft', [CampaignController::class, 'draft'])->middleware('jwt.verify');
    Route::put('/{id}/update', [CampaignController::class, 'update'])->middleware('jwt.verify');
    //    Route::post('/publish', [CampaignController::class, 'publish'])->middleware('jwt.verify');
    //    Route::post('/draft', [CampaignController::class, 'draft'])->middleware('jwt.verify');
    Route::delete('/{campaign:id}/delete', [CampaignController::class, 'destroy'])->middleware('jwt.verify');

    Route::get('isExist/{slug}', [ActivityController::class, 'isExist']);

    Route::post('/{campaign}/report', [CampaignReportController::class, 'report'])->middleware('jwt.verify');
    Route::delete('/{campaign}/report', [CampaignReportController::class, 'cancelReport'])->middleware('jwt.verify');
});

Route::get('/galangdanasaya', [CampaignController::class, 'myCampaigns'])->middleware('jwt.verify');

Route::get('/aktivitas', [ActivityController::class, 'index']);
    Route::prefix('aktivitas')->group(function () {    
    Route::get('/{activity}', [ActivityController::class, 'show']);
    Route::get('/byslug/{activity}', [ActivityController::class, 'bySlug']);
    Route::post('/create', [ActivityController::class, 'create'])->middleware('jwt.verify');
    Route::post('/create/publish', [ActivityController::class, 'publish'])->middleware('jwt.verify');
    Route::post('/create/draft', [ActivityController::class, 'draft'])->middleware('jwt.verify');
    Route::post('/{id}/update', [ActivityController::class, 'update'])->middleware('jwt.verify');
    Route::get('isExist/{slug}', [ActivityController::class, 'isExist']);
    Route::get('/peserta/{activity}',[ActivityController::class, 'showPeserta'])->middleware('jwt.verify');
});

    Route::get('/aktivitassaya', [ActivityController::class, 'myActivities'])->middleware('jwt.verify');

    Route::prefix('kriteria')->group(function () {
    Route::post('/{activity}', [CriteriaController::class, 'create'])->middleware('jwt.verify');
    Route::get('/{activity}', [CriteriaController::class, 'show']);
    Route::put('/{id}', [CriteriaController::class, 'update'])->middleware('jwt.verify');
    Route::delete('/{id}', [CriteriaController::class, 'delete'])->middleware('jwt.verify');
});

    Route::prefix('tugas')->group(function () {
    Route::post('/{activity}', [TaskController::class, 'create'])->middleware('jwt.verify');
    Route::get('/{activity}', [TaskController::class, 'show']);
    Route::put('/{id}', [TaskController::class, 'update'])->middleware('jwt.verify');
    Route::delete('/{id}', [TaskController::class, 'delete'])->middleware('jwt.verify');
});

    Route::prefix('kabar_terbaru')->middleware('jwt.verify')->group(function () {
    Route::post('upload', [KabarTerbaruController::class, 'upload']);
    Route::post('store', [KabarTerbaruController::class, 'store']);
});

    Route::prefix('urgent')->group(function () {
    Route::get('/', [UrgentCampaignsController::class, 'index']);
});

    Route::prefix('fundraiser')->middleware(['jwt.verify', 'fundraiser'])->group(function () {
    Route::get('/getdonatur', [FundraiserController::class, 'getdonatur']);
    Route::get('/donations', [FundraiserController::class, 'getDonaturByReferral']);
    Route::get('/approve', [FundraiserController::class, 'approve']);
    Route::get('/ditolak', [FundraiserController::class, 'ditolak']);
    Route::get('/ringkasanharian', [FundraiserController::class, 'ringkasanHarian']);
    Route::get('/ringkasan', [FundraiserController::class, 'ringkasan']);
    Route::get('/donations/{id}/details', [FundraiserController::class, 'detailDonation']);
});

Route::prefix('doa')->group(function () {
    Route::get('/', [DoaDanKabarBaikController::class, 'index']);
    Route::get('/{doa}', [DoaDanKabarBaikController::class, 'show']);
});

Route::prefix('donation')->group(function () {
    Route::post('/', [DonationController::class, 'submit']);    
    Route::get('/checkreferal', [DonationController::class, 'checkReferalCode']);
    Route::post('/bank_transfer', [BankTransferController::class, 'submit'])->middleware('jwt.verify');
    Route::post('/emoney', [EMoneyController::class, 'submit'])->middleware('jwt.verify');
    Route::post('/balance', [BalanceController::class, 'submit'])->middleware('jwt.verify');

    Route::get('/riwayat/{user_id}', [DonationController::class, 'riwayat'])->middleware('jwt.verify');
    Route::get('/histories/{id}/details', [DonationController::class, 'detailsHistory'])->middleware('jwt.verify');
    Route::get('/transaction/{kode_id}', [DonationController::class, 'transactionHistory']);
});

Route::prefix('participation')->middleware('jwt.verify')->group(function () {
    Route::post('/{activity}', [ParticipationController::class, 'submit']);
    Route::get('/{activity}/participants', [ParticipationController::class, 'participants']);
});

Route::post('/payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);

Route::prefix('password')->group(function () {
    Route::get('/resetemail', [PasswordController::class, 'resetEmail']);
    Route::get('/reset', [PasswordController::class, 'resetPassword']);
    Route::post('/request-otp', [PasswordController::class, 'requestOtp']);
    Route::post('/verify-otp', [PasswordController::class, 'verifyOtp']);
});

Route::group(['middleware' => ['web']], function () {
    Route::prefix('token')->group(function () {
        Route::get('/csrf', [TokenController::class, 'csrfToken']);
    });
});

Route::prefix('wishlists')->middleware('jwt.verify')->group(function () {
    Route::get('/', [WishlistController::class, 'index']);
    Route::post('/create', [WishlistController::class, 'add']);
    Route::delete('/{campaign_id}/delete', [WishlistController::class, 'delete']);
});

// belum termasuk rating user
Route::get('search', [SearchController::class, 'index']);

Route::prefix('slides')->group(function () {
    Route::post('/create', [SliderController::class, 'create']);
});

Route::prefix('topup')->middleware('jwt.verify')->group(function () {
    Route::get('{transaction:id}/details', [TransactionController::class, 'details']);
    Route::post('/bank_transfer', [TransactionController::class, 'bank_payment']);
    Route::post('/emoney', [TransactionController::class, 'emoney']);
});

Route::prefix('verification')->middleware('jwt.verify')->group(function () {
    Route::get('/', [AccountVerificationController::class, 'index']);
    Route::post('/pribadi', [AccountVerificationController::class, 'pribadi']);
    Route::post('/organisasi', [AccountVerificationController::class, 'organisasi']);
    Route::post('/{account_verification:id}/verified', [AccountVerificationController::class, 'verified']);
});

Route::prefix('feeds')->group(function () {
    Route::get('/', [FeedController::class, 'index']);
    Route::post('/{feed}/like', [LikeController::class, 'like'])->middleware('jwt.verify');
    Route::delete('/{feed}/like', [LikeController::class, 'unlike'])->middleware('jwt.verify');
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
});

Route::prefix('adayangbaru')->group(function () {
    Route::get('/', [AdaYangBaruController::class, 'index']);
    Route::post('/create', [AdaYangBaruController::class, 'create'])->middleware('jwt.verify');
    Route::put('/{id}', [AdaYangBaruController::class, 'update'])->middleware('jwt.verify');
    Route::delete('/{id}', [AdaYangBaruController::class, 'delete'])->middleware('jwt.verify');
});

Route::prefix('companies')->group(function () {
    Route::get('/', [CompanyController::class, 'index']);
});

Route::prefix('admin')->middleware(['jwt.verify','admin'])->group(function () {
    Route::get('/users', [UserAdminController::class, 'index']);
    Route::get('/donation/all', [DonationController::class, 'index']);
    Route::get('/aktivitas', [ActivityAdminController::class, 'index']);
    Route::put('/change-user/{userId}', [UserAdminController::class, 'changeToOrganisasi']);    
    Route::delete('/aktivitas/{activity:id}/delete', [ActivityController::class, 'destroy'])->middleware('jwt.verify');    
    Route::get('/transaction/{kode_id}', [DonationController::class, 'transactionHistory']);
    Route::get('/aktivitas/status',[ActivityAdminController::class,'show']);
    Route::get('/users/new-user',[UserAdminController::class, 'getNewUser']);
    Route::post('/slides/create', [SliderController::class, 'create']);
    Route::get('/slides/', [SliderController::class, 'index']);
    Route::post('/slides/{id}/update', [SliderController::class, 'update']);
    Route::delete('/slides/{id}/delete', [SliderController::class, 'delete']);
});


