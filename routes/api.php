<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\RoutePath;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::post('/create-profile', [\App\Http\Controllers\UserController::class, 'store']);
    Route::get('/profile/{id}', [\App\Http\Controllers\UserController::class, 'index']);
    // Other routes within the 'user' group
});


Route::prefix('admin')->middleware(['auth:sanctum','isAdmin'])->group(function () {
   

    Route::get('/settings', [\App\Http\Controllers\Admin\AdminController::class, 'getSettings']);
    Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index']);
    Route::get('/users/pending', [\App\Http\Controllers\Admin\PendingUserRequestController::class, 'index']);
    Route::get('/users/role/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'filterByRole']);
    Route::post('/users/pending/{id}', [\App\Http\Controllers\Admin\PendingUserRequestController::class, 'acceptUser']);
    Route::post('/users/teacher/{id}/subjects', [\App\Http\Controllers\Admin\TeacherController::class, 'addSubjects']);
    Route::get('/users/teacher/subjects', [\App\Http\Controllers\Admin\TeacherController::class, 'getTeacherSubjects']);
    Route::post('/users/teacher/schedule/add', [\App\Http\Controllers\Admin\ScheduleController::class, 'addSchedule']);
    Route::get('/users/teacher/schedule/{id}', [\App\Http\Controllers\Admin\ScheduleController::class, 'getSchedule']);
    Route::post('/users/teacher/classes', [\App\Http\Controllers\Admin\TeacherController::class, 'getClasses']);




    Route::get('/academics/', [\App\Http\Controllers\Admin\AcademicsController::class, 'index']);
    Route::post('/academics/course/add', [\App\Http\Controllers\Admin\AcademicsController::class, 'addCourse']);
    Route::post('/academics/subject/add', [\App\Http\Controllers\Admin\AcademicsController::class, 'addSubject']);
    Route::get('/academics/subject/{id}', [\App\Http\Controllers\Admin\AcademicsController::class, 'getSubjects']);
    Route::get('/academics/course/', [\App\Http\Controllers\Admin\AcademicsController::class, 'getCourses']);
});

Route::get('roles',[\App\Http\Controllers\RoleController::class, 'index']);