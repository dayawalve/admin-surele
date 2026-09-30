<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PermissionListingController, RolePermissionController, StudentsController, CollegeController, TrainingProgramController, StudentsPaymentController, CompanySettingsController, ReportsController, BillingsController, BusinessDeveloperController, RawStudentController, EmployeeController, DomainController, IdealTimeReasonController, BasicSettingController, BrandsController, AIModelController, BrandPermissionsController, SubscriptionPlanController};
use App\Http\Controllers\Admin\{AdminController, HomeController};
use App\Http\Controllers\Admin\Auth\{AuthenticatedSessionController, PasswordResetLinkController, NewPasswordController, EmailVerificationPromptController, VerifyEmailController, EmailVerificationNotificationController, ConfirmablePasswordController};

date_default_timezone_set('Asia/Kolkata');

Route::get('/', function () {
    return redirect()->route('admin.login');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.index');
});

Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::prefix('admin')->group(static function () {
    Route::middleware('guest:admin')->group(static function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('admin.login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('admin.password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('admin.password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('admin.password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('admin.password.update');
    });

    Route::middleware(['auth:admin'])->group(static function () {
        Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('admin.verification.notice');
        Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('admin.verification.verify');
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('admin.verification.send');
    });

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('admin.logout');
    Route::middleware(['auth:admin', 'verified'])->group(static function () {
        Route::name('admin.')->group(static function () {
            Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
            Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
            Route::get('/', [HomeController::class, 'index'])->name('index');
            Route::get('profile', [HomeController::class, 'profile'])->middleware('password.confirm.admin')->name('profile');
            Route::patch('profile', [HomeController::class, 'update'])->name('profile.update');
            Route::patch('profile-email-change', [HomeController::class, 'updateEmail'])->name('profile.update-email');
            Route::patch('profile-password-change', [HomeController::class, 'updatePassword'])->name('profile.update-password');
            Route::patch('delete-account', [HomeController::class, 'deleteAccount'])->name('deleteAccount');
            Route::get('Ajax/VerifyUser', [HomeController::class, 'VerifyUser']);
            Route::get('Ajax/VerifyUser', [AdminController::class, 'VerifyUser'])->name('VerifyUser');
            Route::get('ChangeStatus/{id}', [AdminController::class, 'ChangeStatus'])->name('ChangeStatus');
            // Route::get('students/status/{id}', [StudentsController::class, 'status'])->name('students.status');
            // Route::get('colleges/status/{id}', [CollegeController::class, 'status'])->name('colleges.status');
            Route::post('students/{id}/add-payment', [StudentsController::class, 'addPayment'])->name('students.add-payment');

            Route::post('students/{id}/send-payment-reminder', [StudentsController::class, 'sendPaymentReminder'])->name('students.send-payment-reminder');
            Route::post('/students/{id}/send-offer-letter', [StudentsController::class, 'sendOfferLetter'])->name('students.send-offer-letter');
            Route::get('generate-invite-message-/{id}', [RawStudentController::class, 'sendTrainingInvite'])->name('sendTrainingInvite');
            Route::get('/employees/{employee}/export', [EmployeeController::class, 'export'])->name('employees.export');
        });
    });

    Route::middleware(['auth:admin', 'verified'])->group(static function () {
        Route::name('admin.')->group(static function () {
            Route::resource('users', AdminController::class);
            Route::resource('role-permission', RolePermissionController::class);
            Route::resource('permission-listing', PermissionListingController::class);
            Route::resource('students', StudentsController::class);
            Route::resource('colleges', CollegeController::class);
            Route::resource('training-programs', TrainingProgramController::class);
            Route::resource('students-payment', StudentsPaymentController::class);
            Route::resource('company-settings', CompanySettingsController::class);
            Route::resource('reports', ReportsController::class);
            Route::resource('billings', BillingsController::class);
            Route::resource('business-developers', BusinessDeveloperController::class);
            Route::resource('raw-students', RawStudentController::class);
            Route::resource('employees', EmployeeController::class);
            Route::resource('domains', DomainController::class);
            Route::resource('ideal-time-reason', IdealTimeReasonController::class);
            Route::resource('basic-settings', BasicSettingController::class);
            Route::resource('leads', \App\Http\Controllers\Admin\LeadController::class);
            
            Route::get('brands/export-excel', [BrandsController::class, 'exportExcel'])->name('brands.export-excel');
            Route::post('brands/toggle-aeo/{id}', [BrandsController::class, 'toggleAeo'])->name('brands.toggle-aeo');
            Route::resource('brands', BrandsController::class);
            Route::resource('brand_permissions', BrandPermissionsController::class);
            Route::resource('ai-models', AIModelController::class);
            Route::post('subscription-plans/toggle-status/{id}', [SubscriptionPlanController::class, 'toggleStatus'])->name('subscription-plans.toggle-status');
            Route::resource('subscription-plans', SubscriptionPlanController::class);
            Route::get('dataforseo-costing', [\App\Http\Controllers\Admin\DataForSEOCostingController::class, 'index'])->name('dataforseo-costing.index');

            Route::post('/raw-students/import', [RawStudentController::class, 'import'])->name('raw.students.import');
            Route::get('students/status/{id}', [StudentsController::class, 'status'])->name('students.status');
            Route::get('colleges/status/{id}', [CollegeController::class, 'status'])->name('colleges.status');
            Route::get('training-programs/status/{id}', [TrainingProgramController::class, 'status'])->name('training-programs.status');
            Route::get('business-developers/status/{id}', [BusinessDeveloperController::class, 'status'])->name('business-developers.status');
            Route::get('employees/status/{id}', [EmployeeController::class, 'status'])->name('employees.status');
            Route::get('employees/toggle/{id}', [EmployeeController::class, 'toggle'])->name('employees.toggle');
            Route::put('ideal-time-reason/{id}/approve', [IdealTimeReasonController::class, 'approve'])->name('ideal-time-reason.approve');
            Route::put('ideal-time-reason/{id}/reject', [IdealTimeReasonController::class, 'reject'])->name('ideal-time-reason.reject');
        });
    });
});
