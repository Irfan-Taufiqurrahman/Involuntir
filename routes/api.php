<?php

use App\Http\Controllers\Api\{
    AccountVerificationController,
    Admin\UserAdminController,
    Admin\CampaignAdminController,
    ActivityController,
    CriteriaController,
    TaskController,
    ParticipationController,
    CampaignController,
    CategoryController,
    CompanyController,
    DoaDanKabarBaikController,
    DonationController,
    AdaYangBaruController,
    GoogleController,
    LikeController,
    RencanaPenggunaanDanaController,
    CampaignReportController,
    TokenController,
    AuthController,
    BankTransferController,
    EMoneyController,
    FeedController,
    FundraiserController,
    NotificationController,
    PasswordController,
    PaymentController,
    SliderController,
    UserController,
    WishlistController
};
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\KabarTerbaruController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransaksiController;
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

    // RENCANA PENGGUNAAN
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

Route::prefix('aktivitas')->group(function () {
    Route::get('/', [ActivityController::class, 'index']);
    Route::get('/{activity}', [ActivityController::class, 'show']);
    Route::get('/byslug/{activity}', [ActivityController::class, 'bySlug']);

    Route::post('/create', [ActivityController::class, 'create'])->middleware('jwt.verify');
    Route::post('/create/publish', [ActivityController::class, 'publish'])->middleware('jwt.verify');
    Route::post('/create/draft', [ActivityController::class, 'draft'])->middleware('jwt.verify');
    Route::put('/{id}/update', [ActivityController::class, 'update'])->middleware('jwt.verify');
    Route::delete('/{activity:id}/delete', [ActivityController::class, 'destroy'])->middleware('jwt.verify');

    Route::get('isExist/{slug}', [ActivityController::class, 'isExist']);
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
    Route::get('/all', [DonationController::class, 'index']);
    Route::get('/checkreferal', [DonationController::class, 'checkReferalCode']);
    Route::post('/bank_transfer', [BankTransferController::class, 'submit']);
    Route::post('/emoney', [EMoneyController::class, 'submit']);
    Route::post('/balance', [BalanceController::class, 'submit'])->middleware('jwt.verify');

    Route::get('/histories', [DonationController::class, 'histories'])->middleware('jwt.verify');
    Route::get('/histories/{id}/details', [DonationController::class, 'detailsHistory'])->middleware('jwt.verify');
    Route::get('/transaction/{kode_id}', [DonationController::class, 'transactionHistory']);
});

Route::prefix('participation')->middleware('jwt.verify')->group(function () {
    Route::post('/', [ParticipationController::class, 'submit']);
    Route::get('/{activity}/participants', [ParticipationController::class, 'participants']);
});

Route::post('/payments/midtrans-notification', [PaymentCallbackController::class, 'receive']);
// Route::prefix('payment')->group(function () {
//     // Route::post('/token', [PaymentController::class, 'getToken']);
//     // Route::post('/submit', [PaymentController::class, 'submitDonation']);
//     // Route::get('/method', [PaymentController::class, 'paymentMethod']);
// });

// Route::post('/notification/push', [NotificationController::class, 'post']);


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
    Route::get('/', [SliderController::class, 'index']);
    Route::post('/create', [SliderController::class, 'create']);
    Route::put('/{id}/update', [SliderController::class, 'update']);
    Route::delete('/{id}/delete', [SliderController::class, 'delete']);
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

// ADMIN ROUTE
Route::prefix('admin')->middleware(['jwt.verify', 'admin'])->group(function () {
    Route::get('/users', [UserAdminController::class, 'index']);
    Route::get('/galangdana', [CampaignAdminController::class, 'index']);
});
