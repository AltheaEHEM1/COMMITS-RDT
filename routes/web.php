<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\InventoryExportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PatientHistoryController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\ActivityLogController;

// Guest routes
Route::middleware(['guest'])->group(function () {
    // Default landing
    Route::get('/', function () {
        return redirect()->route('login.show');
    });

    Route::get('/login', [UserController::class, 'showLogin'])->name('login.show');
    Route::post('/login', [UserController::class, 'login'])->name('login');

    // Forgot password route
    Route::view('/forgot-password', 'authentication.forgot-password')->name('password.request');

    // Validate the email and send the password reset link to the corresponding email/user
    Route::post('/forgot-password', [ForgotPasswordController::class, 'passwordEmail']);

    // Reset password route
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'passwordReset'])->name('password.reset');

    // Validate the password reset request and update the password
    Route::post('/reset-password', [ForgotPasswordController::class, 'passwordUpdate'])->name('password.update');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // User Logout route
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    Route::get('/profile/settings', [ProfileController::class, 'accountSettings'])
        ->name('profile.accountSettings');

    // Add these profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/settings', [ProfileController::class, 'accountSettings'])->name('profile.accountSettings');
        Route::get('/changePassword', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
        Route::post('/update', [ProfileController::class, 'updateProfile'])->name('profile.updateProfile');
        Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    });

    // Settings Routes
    Route::prefix('settings')->group(function () {
        Route::get('/profile', [SettingController::class, 'profile'])->name('user.profile');
        Route::get('/change-password', [SettingController::class, 'changePassword'])->name('password.change');
        Route::post('/update-password', [SettingController::class, 'updatePassword'])->name('update.password');
        Route::post('/update-profile', [SettingController::class, 'updateProfile'])->name('profile.update');
    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });

    // PATIENTS
    Route::prefix('patients')->group(function () {
        // Route::get('/', [PatientController::class, "index"])->name('patients');
        // Show all patients (index page)
        Route::get('/', [PatientController::class, 'index'])->name('patients');
        // Show form to add a new patient
        Route::get('/new', [PatientController::class, 'add'])->name('patients.add');
        // Store a new patient
        Route::post('/store', [PatientController::class, 'store'])->name('patients.store');
        // Show the edit form for a specific patient
        Route::get('/edit/{id}', [PatientController::class, 'edit'])->name('patients.edit');
        // Update a patient record
        Route::put('/update/{id}', [PatientController::class, 'update'])->name('patients.update');
        // Delete a patient record
        Route::delete('/destroy/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');

        // Prescription routes
        Route::post('/prescriptions', [PatientController::class, 'storePrescription'])->name('prescriptions.store');
        Route::get('/prescriptions/{patient}', [PatientController::class, 'getPrescriptions'])->name('prescriptions.get');
    });


    // INVENTORY
    Route::prefix('inventory')->group(function () {
        Route::get('/', function () {
            return redirect()->route('inventory-medicines');
        })->name('inventory');

        // Medicines
        Route::prefix('medicines')->group(function () {
            Route::controller(MedicineController::class)->group(function () {
                Route::get('/', 'index')->name('inventory-medicines');
                Route::get('/{medicine}', 'show')->name('medicines.show');
                Route::post('/', 'store')->name('add_medicine_store');
                Route::put('/{medicine}', 'update')->name('update_medicine');
                Route::put('/{medicine}/deduct', 'deduct')->name('deduct_medicine');
                Route::put('/{medicine}/return', 'return')->name('return_medicine');
                Route::delete('/{medicine}', 'destroy')->name('delete_medicine');
            });
        });

        // Supplies
        Route::prefix('supplies')->group(function () {
            Route::controller(SupplyController::class)->group(function () {
                Route::get('/', 'index')->name('inventory-supplies');
                Route::post('/', 'store')->name('supplies.store');
                Route::get('/{supply}/edit', 'edit')->name('edit_supply');
                Route::put('/{supply}', 'update')->name('update_supply');
                Route::put('/{supply}/deduct', 'deduct')->name('deduct_supply');
                Route::put('/{supply}/return', 'return')->name('return_supply');
                Route::delete('/{supply}', 'destroy')->name('delete_supply');
            });
        });

        // Equipment
        Route::prefix('equipment')->group(function () {
            Route::controller(EquipmentController::class)->group(function () {
                Route::get('/', 'index')->name('inventory-equipment');
                Route::post('/', 'store')->name('equipment.store');
                Route::put('/{equipment}/update', 'update')->name('update_equipment');
                // Route::put('/{equipment}/deduct', 'deduct')->name('deduct_equipment');
                Route::delete('/{equipment}', 'destroy')->name('delete_equipment');
            });
        });

        // Add this route in an appropriate section of your web.php file
        Route::get('/export/{type}', [App\Http\Controllers\InventoryExportController::class, 'export'])->name('inventory.export');
    });

    //Fuzzy Search Route
    Route::post('/patients/check-similar', [PatientController::class, 'checkSimilar'])->name('patients.check-similar');

    // Document Routes
    Route::prefix('documents')->group(function () {
        Route::get('/', [DocumentController::class, 'index'])->name('documents.index');

        // Routes for each document type
        $documentTypes = [
            'excuse_letter' => 'Excuse Letter',
            'medical_clearance' => 'Medical Clearance',
            'medical_certificate' => 'Medical Certificate',
            'annual_medical_clearance' => 'Annual Medical Clearance',
            'waiver' => 'Waiver',
            'waiver_for_pulmonary_case' => 'Waiver for Pulmonary Case',
            'dmdc_consent_form' => 'DMDC Consent Form',
        ];

        foreach ($documentTypes as $slug => $type) {
            // Create Document
            Route::get("/create/{$slug}", [DocumentController::class, 'create'])
                ->name("documents.{$slug}.create")
                ->defaults('document_type', $type);

            // Store Document
            Route::post("/store/{$slug}", [DocumentController::class, 'store'])
                ->name("documents.{$slug}.store")
                ->defaults('document_type', $type);

            // Edit Document
            Route::get("/{id}/edit/{$slug}", [DocumentController::class, 'edit'])
                ->name("documents.{$slug}.edit")
                ->defaults('document_type', $type);

            // Update Document
            Route::put("/{id}/update/{$slug}", [DocumentController::class, 'update'])
                ->name("documents.{$slug}.update")
                ->defaults('document_type', $type);

            // View Document (new route)
            Route::get("/{id}/view/{$slug}", [DocumentController::class, 'view'])
                ->name("documents.{$slug}.view")
                ->defaults('document_type', $type);

            Route::delete("/{id}/delete/{$slug}", [DocumentController::class, 'softDelete'])
                ->name("documents.{$slug}.delete")
                ->defaults('document_type', $type);

        }
    });
    //Control Number
    Route::post('/documents', [DocumentController::class, 'ControlNumber'])->name('control-numbers.store');
    Route::put('/documents/{id}', [DocumentController::class, 'updateControlNumber'])->name('control-numbers.update');
    Route::get('/documents/edit/{id}', [DocumentController::class, 'editControlNumber'])->name('control-number.edit');    // Report Routes
    Route::prefix('reports')->group(function () {

        // Display a list of reports, allowing filters
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');

        // Show a single report
        Route::get('/{id}', [ReportController::class, 'show'])->name('reports.show');;

        // Store a new report
        Route::post('/', [ReportController::class, 'store'])->name('reports.store');

        // Delete a report
        Route::post('/delete', [ReportController::class, 'destroy'])->name('reports.destroy');
        Route::get('/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
        Route::put('/update', [ReportController::class, 'update'])->name('reports.update');
        Route::get('/reports/export-excel', [ReportController::class, 'exportExcel'])->name('reports.exportExcel');
    });

    Route::get('/reportPaper', [ReportController::class, 'showReportPaper'])->name('reports.showReportPaper');
    Route::post('/reportPaper', [ReportController::class, 'filterAndCountReports'])->name('reports.filterAndCountReports');

    // Patient History
    Route::get('/history', [PatientHistoryController::class, 'index'])->name('History.all');

    // Mark notification as read
    Route::post('/notifications/{notification}/mark-as-read', function(App\Models\Notification $notification) {
        if (Auth::check()) {
            $userId = Auth::id();

            // Get current viewed_by array
            $viewedBy = json_decode($notification->viewed_by ?: '[]', true);

            // Add current user if not already in the array
            if (!in_array($userId, $viewedBy)) {
                $viewedBy[] = $userId;
                $notification->viewed_by = json_encode($viewedBy);
                $notification->save();
            }

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 403);
    })->name('notifications.markAsRead')->middleware('web');

    // Add this with your other notification routes
    Route::post('/notifications/mark-viewed-by-user', [NotificationController::class, 'markViewedByUser'])
        ->name('notifications.markViewedByUser');

    Route::post('/notifications/mark-as-viewed', [NotificationController::class, 'markAsViewed']);
    Route::post('/notifications/clear-all', [NotificationController::class, 'clearAll'])
        ->name('notifications.clearAll')
        ->middleware('auth');
});



//Super Admin
Route::middleware(['auth', 'superadmin'])->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('/', function () {
            return redirect()->route('Superadmin_dashboard');
        });

        //Dashboard
        Route::get('/dashboard', [DashboardController::class, 'superadminDashboard'])->name('Superadmin_dashboard');

        // User management
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'getUsers'])->name('users.get');
            // Add this to your routes/web.php
            Route::get('/admin/users/add', [UserController::class, 'create'])->name('user.create');
            Route::post('/admin/users/add', [UserController::class, 'store'])->name('user.store');
            Route::post('/edit', [UserController::class, 'update'])->name('user.update');
            Route::post('/delete', [UserController::class, 'delete'])->name('user.destroy');
        });

        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('Auditlog');
    });
});