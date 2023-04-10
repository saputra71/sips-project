<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MenjabatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\IngoingMailController;
use App\Http\Controllers\OutgoingMailController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\DispositionController;
use App\Http\Livewire\Document\Index as DocumentIndex;
use App\Http\Livewire\SuratMasuk\Index as IngoingMailIndex;
use App\Http\Livewire\Pegawai\Index as EmployeeIndex;
use App\Http\Livewire\Menjabat\Index as MenjabatIndex;
use App\Http\Livewire\OutgoingMail\Index as OutgoingMailIndex;
use App\Http\Livewire\IngoingMail\Index as IngoingMailsIndex;
use App\Http\Livewire\Notification\Index as NotificationIndex;
use App\Http\Livewire\Inbox\Index as InboxIndex;
use App\Http\Livewire\Log\LogActivity;

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

Route::get('/backup', [DashboardController::class, 'backup']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::post('/mark-as-read/{id}', [DashboardController::class, 'markNotification'])->name('markNotification');
    Route::get('/showSurat/{id}', [DashboardController::class, 'showSurat'])->name('showSurat');
    Route::get('/showSuratKeluar/{id}', [DashboardController::class, 'showSuratKeluar'])->name('showSuratKeluar');
});

Route::name('dashboard.')->prefix('dashboard')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('index');
    Route::middleware([
        'auth:sanctum',
    ])->group(function () {

        Route::resource('ingoing-mails', IngoingMailController::class);
        // index dengan livewire
        Route::get('ingoing-mails', IngoingMailsIndex::class)->name('ingoing-mails.index')->middleware('permission:ingoing-list');

        Route::resource('outgoing-mails', OutgoingMailController::class);
        Route::get('outgoing-mails', OutgoingMailIndex::class)->name('outgoing-mails.index');

        Route::post('outgoing-mails/create/template/{outgoingMail}', [OutgoingMailController::class, 'templateSuratEdaran'])->name('outgoing-mails.template');
        Route::get('outgoing-mails/template/{outgoingMail}', [OutgoingMailController::class, 'viewTemplate'])->name('outgoing-mails.view-template');
        Route::get('outgoing-mails/view/{outgoingMail}', [OutgoingMailController::class, 'view'])->name('outgoing-mails.view');


        Route::post('ingoing-mails/disposisi/{ingoingMail}', [IngoingMailController::class, 'disposisi'])->name('ingoing-mails.disposisi');

        Route::get('documents', DocumentIndex::class)->name('documents.index')->middleware('permission:document-list');

        // Route::resource('employees', EmployeeController::class);
        Route::get('employees', EmployeeIndex::class)->name('employees.index');

        Route::resource('roles', RoleController::class)->except('destroy')->middleware('permission:role-list');
        Route::get('/roles/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:role-delete');

        Route::resource('permissions', PermissionController::class);

        Route::resource('dispositions', DispositionController::class);

        Route::get('notifications', NotificationIndex::class)->name('notifications.index');

        Route::get('inbox', InboxIndex::class)->name('inbox.index');
        Route::get('activity-logs', LogActivity::class)->name('activity-logs.index')->middleware('permission:view-logs');
    });
});
Route::get('outgoing-mails', OutgoingMailIndex::class)->name('outgoing-mails.index');

Route::get('/exportExcel', [IngoingMailController::class, 'ingoingexport'])->name('data.export');
