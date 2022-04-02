<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AppliedProgrammeController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ProgrammeController;

use App\Http\Controllers\FileController;

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


/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes(['verify' => true]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/applications', ApplicationController::class)->middleware('auth','verified')->names([
    'create' => 'application.build'
]);


Route::get('personal', [ApplicationController::class, 'personal'])->middleware('auth','verified')->middleware('roles:user')->name('personal');
Route::get('acade', [ApplicationController::class, 'acade'])->middleware('auth','verified')->middleware('roles:user');
Route::get('detail', [ApplicationController::class, 'detail'])->middleware('auth','verified')->middleware('roles:officer')->name('detail');

Route::resource('/appliedProgrammes', AppliedProgrammeController::class)->middleware('auth','verified');
Route::get('apply', [AppliedProgrammeController::class, 'apply'])->middleware('auth','verified')->middleware('roles:user')->name('apply');
Route::get('applyRequirement', [AppliedProgrammeController::class, 'applyRequirement'])->middleware('auth','verified')->middleware('roles:user')->name('applyRequirement');
Route::get('status', [AppliedProgrammeController::class, 'status'])->middleware('auth','verified')->middleware('roles:user')->name('status');
Route::get('manage', [AppliedProgrammeController::class, 'manage'])->middleware('auth','verified')->middleware('roles:officer')->name('manage');
Route::get('viewFile/{user_id}', [AppliedProgrammeController::class, 'viewFile'])->middleware('auth','verified')->middleware('roles:officer')->name('viewFile');
Route::get('decide', [AppliedProgrammeController::class, 'decide'])->middleware('auth','verified')->middleware('roles:officer');
Route::get('assign', [AppliedProgrammeController::class, 'assign'])->middleware('auth','verified')->middleware('roles:officer')->name('assign');
//Route::get('remindEmail', [AppliedProgrammeController::class, 'remindEmail'])->middleware('auth','verified')->middleware('roles:officer')->name('remindEmail');

Route::resource('/interviews', InterviewController::class)->middleware('auth','verified');
Route::get('timeSlotCreate', [InterviewController::class, 'timeSlotCreate'])->middleware('auth')->middleware('roles:officer')->name('timeSlotCreate');
Route::get('interviewManage', [InterviewController::class, 'interviewManage'])->middleware('auth')->middleware('roles:officer')->name('interviewManage');
Route::get('interviewChange', [InterviewController::class, 'interviewChange'])->middleware('auth')->middleware('roles:officer')->name('interviewChange');
Route::get('interviewChangeSelect/{appliedProgrammeId}', [InterviewController::class, 'interviewChangeSelect'])->middleware('auth')->middleware('roles:officer')->name('interviewChangeSelect');
Route::get('interviewPeriodDetails', [InterviewController::class, 'interviewPeriodDetails'])->middleware('auth')->middleware('roles:officer')->name('interviewPeriodDetails');
Route::get('waitingAssign', [InterviewController::class, 'waitingAssign'])->middleware('auth')->middleware('roles:officer')->name('waitingAssign');
Route::get('/getEmptyTime/{timePeriodId}', [InterviewController::class, 'getEmptyTime'])->name('getEmptyTime');
//Route::get('/interviews/status', [InterviewController::class, 'interviewStatus'])->middleware('auth')->middleware('roles:officer')->name('interviewStatus');


Route::resource('/userManagement', UserManagementController::class)->middleware('auth','verified')->middleware('roles:admin');
Route::get('/userManage', [UserManagementController::class, 'userManage'])->middleware('auth','verified')->middleware('roles:admin')->name('userManage');
Route::get('/createOfficer', [UserManagementController::class, 'createOfficer'])->middleware('auth','verified')->middleware('roles:admin')->name('createOfficer');
Route::get('/activeAccount', [UserManagementController::class, 'activeAccount'])->middleware('auth','verified')->middleware('roles:user')->name('activeAccount');

Route::get('/remind', [App\Http\Controllers\RemindController::class, 'create'])->middleware('auth','verified');
Route::post('/remind', [App\Http\Controllers\RemindController::class, 'sendEmail'])->middleware('auth','verified')->name('send.email');

Route::get('/programmeManage', [ProgrammeController::class, 'programmeManage'])->middleware('auth','verified')->middleware('roles:admin')->name('programmeManage');
Route::get('/programmeEdit', [ProgrammeController::class, 'programmeEdit'])->middleware('auth','verified')->middleware('roles:admin')->name('programmeEdit');
Route::post('/programmeEdit', [ProgrammeController::class, 'programmeEdit'])->middleware('auth','verified')->middleware('roles:admin')->name('programmeEdit');
Route::resource('/programmes', ProgrammeController::class)->middleware('auth','verified')->middleware('roles:admin');

Route::resource('/files', FileController::class)->middleware('auth','verified');
Route::get('/fileView', [FileController::class, 'fileView'])->middleware('auth','verified')->middleware('roles:user')->name('fileView');
Route::post('/fileView', [FileController::class, 'fileView'])->middleware('auth','verified')->middleware('roles:user')->name('fileView');
Route::get('get/{filePath}', [FileController::class, 'getFile'])->middleware('auth','verified')->name('files.getfile');




