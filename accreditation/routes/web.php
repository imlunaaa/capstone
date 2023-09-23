<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\SubIndicatorController;
use App\Http\Controllers\ProgramLevelController;
use App\Http\Controllers\AccreditationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SubComponentController;
use App\Http\Controllers\IndicatorCategoryController;
use App\Http\Controllers\IndicatorFileController;
use App\Http\Controllers\SubIndicatorFileController;
use App\Http\Controllers\SubComponentFileController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\AreaMemberController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

//route::get('post',[HomeController::class,'post'])->middleware(['auth', 'admin']);
//route::get('post',[HomeController::class,'post'])->middleware(['auth', 'admin']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('user_list', [UserController::class, 'index']);
    Route::get('add_user', [RegisteredUserController::class, 'create'])->name('add_user');
    Route::post('add_user', [RegisteredUserController::class, 'store']);
    Route::get('user_list/{id}', [UserController::class, 'destroy']);
    Route::get('edit_user/{id}', [UserController::class, 'edit']);
    Route::post('edit_user/{id}', [UserController::class, 'update']);

    Route::get('campus_list', [CampusController::class, 'index']);
    Route::post('campus_list', [CampusController::class, 'store'])->name('campus_list');
    Route::get('campus_list/{id}', [CampusController::class, 'destroy']);
    Route::get('edit_campus/{id}', [CampusController::class, 'edit']);
    Route::post('edit_campus/{id}', [CampusController::class, 'update']);

    Route::get('program_list', [ProgramController::class, 'index']);
    Route::post('program_list', [ProgramController::class, 'store'])->name('program_list');
    Route::get('program_list/{id}', [ProgramController::class, 'destroy']);
    Route::get('edit_program/{id}', [ProgramController::class, 'edit']);
    Route::post('edit_program/{id}', [ProgramController::class, 'update']);

    Route::get('view_areas/{id}', [AreaController::class, 'index']);
    Route::post('area_list', [AreaController::class, 'store'])->name('area_list');
    Route::get('area_list/{id}', [AreaController::class, 'destroy']);
    Route::get('edit_area/{id}', [AreaController::class, 'edit']);
    Route::post('edit_area/{id}', [AreaController::class, 'update']);

    Route::get('manage_parameter/{id}', [ParameterController::class, 'index']);
    Route::post('parameter_list', [ParameterController::class, 'store'])->name('parameter_list');
    Route::get('parameter_list/{id}', [ParameterController::class, 'destroy']);
    Route::get('edit_parameter/{id}', [ParameterController::class, 'edit']);
    Route::post('edit_parameter/{id}', [ParameterController::class, 'update']);

    Route::get('view_indicator/{id}', [IndicatorController::class, 'index'])->name('admin.view_indicator.index');
    Route::post('indicator_list', [IndicatorController::class, 'store'])->name('indicator_list');
    Route::get('indicator_list/{id}', [IndicatorController::class, 'destroy'])->name('delete_indicator');
    Route::get('edit_indicator/{id}', [IndicatorController::class, 'edit']);
    Route::post('edit_indicator/{id}', [IndicatorController::class, 'update']);

    Route::get('program_level_list', [ProgramLevelController::class, 'index']);
    Route::post('program_level_list', [ProgramLevelController::class, 'store'])->name('program_level_list');
    Route::get('program_level_list/{id}', [ProgramLevelController::class, 'destroy']);
    Route::get('edit_program_level/{id}', [ProgramLevelController::class, 'edit']);
    Route::post('edit_program_level/{id}', [ProgramLevelController::class, 'update']);
    
    Route::get('view_indicator/{action}/{id}', [SubIndicatorController::class, 'destroy'])->name('delete_sub_indicator');

    Route::post('add_sub_indicator', [SubIndicatorController::class, 'store'])->name('add_sub_indicator');
    Route::get('edit_sub_indicator/{id}/{pid}', [SubIndicatorController::class, 'edit']);
    Route::post('edit_sub_indicator/{id}', [SubIndicatorController::class, 'update']);

    Route::post('add_sub_component', [SubComponentController::class, 'store'])->name('add_sub_component');
    Route::get('edit_sub_component/{id}/{pid}', [SubComponentController::class, 'edit']);
    Route::post('edit_sub_component/{id}', [SubComponentController::class, 'update']);
    Route::get('delete_sub_component/{id}', [SubComponentController::class, 'destroy']);

    Route::get('manage_accreditation', [AccreditationController::class, 'index']);
    Route::post('manage_accreditation', [AccreditationController::class, 'store'])->name('add_accreditation');
    Route::get('manage_accreditation/{id}', [AccreditationController::class, 'destroy']);

    Route::get('indicator_category_list', [IndicatorCategoryController::class, 'index']);
    Route::post('add_indicator_category', [IndicatorCategoryController::class, 'store']);
    Route::get('edit_indicator_category/{id}', [IndicatorCategoryController::class, 'edit']);
    Route::get('delete_indicator_category/{id}', [IndicatorCategoryController::class, 'destroy']);
    Route::post('edit_indicator_category/{id}', [IndicatorCategoryController::class, 'update']);

    Route::get('instrument_list', [InstrumentController::class, 'index']);
    Route::post('instrument_list', [InstrumentController::class, 'store'])->name('instrument_list');
});

Route::middleware(['auth'])->group(function () {
    Route::get('manage_parameters/{id}', [ParameterController::class, 'index']);
    Route::get('view_indicator_areachair/{id}', [IndicatorController::class, 'index']);

    Route::get('manage_member/{id}', [MemberController::class, 'show'])->name('admin.manage_member.show');
    Route::post('manage_member', [MemberController::class, 'store'])->name('add_members');
    Route::get('manage_member/{action}/{id}', [MemberController::class, 'destroy'])->name('delete_members');
    Route::post('update_role/{id}', [MemberController::class, 'update']);

    Route::get('view_files_indicator/{indicator_id}/{paramter_id}', [IndicatorFileController::class, 'index']);
    Route::post('upload_files_indicator', [IndicatorFileController::class, 'store']);
    Route::get('view_indicator_file/{id}', [IndicatorFileController::class, 'show']);

    Route::get('view_files_subindicator/{subindicator_id}/{paramter_id}', [SubIndicatorFileController::class, 'index']);
    Route::post('upload_files_subindicator', [SubIndicatorFileController::class, 'store']);
    Route::get('view_subindicator_file/{id}', [SubIndicatorFileController::class, 'show']);

    Route::post('add_area_member', [AreaMemberController::class, 'store'])->name('add_area_members');
});

Route::middleware(['auth'])->group(function () {
    Route::get('manage_accreditation', [AccreditationController::class, 'index']);
});

require __DIR__.'/auth.php';
