<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ProfileUpdateController;
use App\Http\Controllers\PersonalUserController;
use App\Http\Controllers\DataPribadiController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CodeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ForumController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();
Route::get('/', function () {
    return view('home');
});
Route::get('/roadmap', function(){
    return view('roadmap');
});
Route::get('/course/belajar-bahasa-pemrograman-python', function(){
    return view('pages.course.belajar-bahasa-pemrograman-python');
});
Route::get('/course/belajar-bahasa-pemrograman-python/persiapan', function(){
    return view('pages.course.belajar-bahasa-pemrograman-python.persiapan');
});
Route::get('/course/belajar-bahasa-pemrograman-python/quiz1', function(){
    return view('pages.course.belajar-bahasa-pemrograman-python.quiz1');
});
Route::get('/roadmap/machine-learning', function(){
    return view('pages.roadmap.machine-learning');
});
Route::get('/kelas', function(){
    return view('kelas');
});
Route::post('/order', [OrderController::class, 'createOrder']);
Route::post('/order/update-status', [OrderController::class, 'updateOrderStatus']);
Route::get('/order/status', [OrderController::class, 'getOrderStatus']);
Route::get('/products', function (Request $request) {
    return Product::all();
});
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('/daftar', function () {
    return view('daftar');
})->name('daftar');
Route::post('/daftar', [RegisterController::class, 'daftar'])->name('daftar');
Route::get('/verify-email/{token}', [RegisterController::class, 'verifyEmail'])->name('verify.email');
Route::post('/data-pribadi', [PersonalUserController::class, 'store'])->name('personal-users.store');
Route::get('/data-pribadi', function(){
    return view('pages.profile.dataPribadi');
});
Route::get('/profile', [ProfileController::class, 'show'])->middleware('auth');
Route::get('/profile', function () {
    return view('pages.profile.profile');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('pages.profile.profile');
    })->name('profile');
    Route::get('/data-pribadi', function(){
        return view('pages.profile.dataPribadi');
    })->name('data-pribadi');
    Route::get('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');
});
Route::middleware('auth')->group(function () {
    Route::post('/profile/updatePhoto', [ProfileController::class, 'updateProfilePhoto'])->name('profile.updatePhoto');
});
Route::middleware('auth')->post('/profile/update', [ProfileUpdateController::class, 'updateProfile'])->name('profile.update');
Route::middleware('auth')->post('/pengaturan/update', [ProfileUpdateController::class, 'updatePengaturan'])->name('pengaturan.update');
Route::middleware('auth')->post('/pengaturan/update-password', [ProfileUpdateController::class, 'updatePassword'])->name('pengaturan.updatePassword');
Route::post('/update-avatar', [AvatarController::class, 'update'])->name('profile.updateAvatar');
Route::get('/riwayat-transaksi', [OrderController::class, 'showOrders'])->name('orders.show');
Route::get('/orders', [OrderController::class, 'showOrders'])->name('orders.show');
Route::post('/midtrans-callback', [OrderController::class, 'handleMidtransCallback'])->name('midtrans.callback');
Route::get('/pengaturan', function(){
    return view('pages.profile.pengaturan');
});
Route::get('/data-pribadi', [DataPribadiController::class, 'showProvinsi']);
Route::get('/cities', [DataPribadiController::class, 'getCities']);
Route::get('/postal-codes', [DataPribadiController::class, 'getPostalCodes']);
Route::get('/reset-discount/{id}', [CheckoutController::class, 'resetDiscount'])->name('reset.discount');
Route::middleware(['check.checkout'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/apply-discount', [CheckoutController::class, 'applyDiscount'])->name('apply.discount');
});
Route::post('/api/start-course', [CourseController::class, 'startCourse']);
Route::post('/api/update-progress', [CourseController::class, 'updateProgress']);
Route::get('/course/belajar-bahasa-pemrograman-python/persiapan/get-progress', [CourseController::class, 'getProgress']);
Route::post('/run-code', [CodeController::class, 'runPythonCode']);
Route::post('/send-message', [MessageController::class, 'sendMessage'])->middleware('auth');
Route::post('/save-progress', [ProgressController::class, 'saveProgress']);
Route::get('/get-progress/{id}', [ProgressController::class, 'getProgress']);
Route::get('/messages/{forumId}', [ForumController::class, 'fetchMessages']);
Route::post('/messages', [ForumController::class, 'sendMessage']);












