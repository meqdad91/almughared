<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QaController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubjectReviewController;
use App\Http\Controllers\TraineeController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('auth:admin')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('admins', [AdminController::class, 'index'])->name('admins.index');
            Route::get('admins/create', [AdminController::class, 'create'])->name('admins.create');
            Route::post('admins', [AdminController::class, 'store'])->name('admins.store');
            Route::get('admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
            Route::put('admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
            Route::delete('admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');

            Route::get('qas', [QaController::class, 'index'])->name('qas.index');
            Route::get('qas/create', [QaController::class, 'create'])->name('qas.create');
            Route::post('qas', [QaController::class, 'store'])->name('qas.store');
            Route::get('qas/{qa}/edit', [QaController::class, 'edit'])->name('qas.edit');
            Route::put('qas/{qa}', [QaController::class, 'update'])->name('qas.update');
            Route::delete('qas/{qa}', [QaController::class, 'destroy'])->name('qas.destroy');

            Route::get('trainers', [TrainerController::class, 'index'])->name('trainers.index');
            Route::get('trainers/create', [TrainerController::class, 'create'])->name('trainers.create');
            Route::post('trainers', [TrainerController::class, 'store'])->name('trainers.store');
            Route::get('trainers/{trainer}/edit', [TrainerController::class, 'edit'])->name('trainers.edit');
            Route::put('trainers/{trainer}', [TrainerController::class, 'update'])->name('trainers.update');
            Route::delete('trainers/{trainer}', [TrainerController::class, 'destroy'])->name('trainers.destroy');

            Route::get('trainees', [TraineeController::class, 'index'])->name('trainees.index');
            Route::get('trainees/create', [TraineeController::class, 'create'])->name('trainees.create');
            Route::post('trainees', [TraineeController::class, 'store'])->name('trainees.store');
            Route::get('trainees/{trainee}/edit', [TraineeController::class, 'edit'])->name('trainees.edit');
            Route::put('trainees/{trainee}', [TraineeController::class, 'update'])->name('trainees.update');
            Route::delete('trainees/{trainee}', [TraineeController::class, 'destroy'])->name('trainees.destroy');
            Route::post('trainees/{trainee}/approve', [TraineeController::class, 'approve'])->name('trainees.approve');
            Route::get('reviews', [SubjectReviewController::class, 'index'])->name('reviews.index');
            Route::get('attendance', [AttendanceController::class, 'adminAttendance'])->name('attendance.index');

            Route::get('subjects/pending', [AdminController::class, 'pendingSubjects'])->name('subjects.pending');
            Route::get('subjects/pending/{subject}', [AdminController::class, 'showPendingSubject'])->name('subjects.pending.show');
            Route::post('subjects/{subject}/approve', [AdminController::class, 'approveSubject'])->name('subjects.approve');
            Route::post('subjects/{subject}/reject', [AdminController::class, 'rejectSubject'])->name('subjects.reject');

            Route::resource('subjects', SubjectController::class);
            Route::resource('sessions', SessionController::class);
            Route::get('/allSubjects', [SubjectController::class, 'allSubjects'])->name('subjects.allSubjects');
            Route::post('/reviews', [SubjectReviewController::class, 'store'])->name('reviews.store');
            Route::put('/reviews/{review}', [SubjectReviewController::class, 'update'])->name('reviews.update');
            Route::delete('/reviews/{review}', [SubjectReviewController::class, 'destroy'])->name('reviews.destroy');
        });
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    });
});



Route::prefix('trainee')->name('trainee.')->group(function () {
    Route::middleware('auth:trainee')->group(function () {
        Route::get('dashboard', [TraineeController::class, 'dashboard'])->name('dashboard');
        Route::get('session', [TraineeController::class, 'sessions'])->name('session.index');
        Route::get('session/show/{id}', [TraineeController::class, 'sessionDetails'])->name('session.show');
        Route::post('subject/{id}/review', [TraineeController::class, 'storeReview'])->name('subject.review.store');
        Route::get('attendance', [AttendanceController::class, 'traineeAttendance'])->name('attendance.index');
    });
});
Route::prefix('qa')->name('qa.')->group(function () {
    Route::middleware('auth:qa')->group(function () {
        Route::get('dashboard', [QaController::class, 'dashboard'])->name('dashboard');
        Route::get('session/pending', [QaController::class, 'pendingSessions'])->name('session.pending');
        Route::get('session/active', [QaController::class, 'activeSessions'])->name('session.active');
        Route::get('subject/pending/{session}', [QaController::class, 'pendingSubjects'])->name('subjects.pending');
        Route::get('subject/active/{session}', [QaController::class, 'activeSubjects'])->name('subjects.active');
        Route::get('subject/{subject}', [QaController::class, 'showSubject'])->name('subjects.show');
        Route::post('subject/{subject}/approve', [QaController::class, 'approveSubject'])->name('subjects.approve');
        Route::post('subject/{subject}/reject', [QaController::class, 'rejectSubject'])->name('subjects.reject');
    });
});
Route::prefix('trainer')->name('trainer.')->group(function () {
    Route::middleware('auth:trainer')->group(function () {
        Route::get('dashboard', [TrainerController::class, 'dashboard'])->name('dashboard');
        Route::get('session/pending', [TrainerController::class, 'pendingSessions'])->name('session.pending');
        Route::get('session/active', [TrainerController::class, 'activeSessions'])->name('session.active');
        Route::get('session/{session}/students', [TrainerController::class, 'sessionStudents'])->name('session.students');
        Route::get('subject/pending/{session}', [TrainerController::class, 'pendingSubjects'])->name('subjects.pending');
        Route::get('subject/active/{session}', [TrainerController::class, 'activeSubjects'])->name('subjects.active');
        Route::resource('subjects', SubjectController::class);
        Route::get('subject/{subject}/attendance', [AttendanceController::class, 'showAttendanceForm'])->name('attendance.create');
        Route::post('subject/{subject}/attendance', [AttendanceController::class, 'storeAttendance'])->name('attendance.store');
    });
});

Route::middleware('auth:admin,qa,trainer,trainee')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['web', 'auth:admin,qa,trainer,trainee'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
});

require __DIR__ . '/auth.php';
