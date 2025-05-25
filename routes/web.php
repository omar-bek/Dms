<?php

use App\Models\Document;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DepartmentsController;
use App\Http\Controllers\Admin\UserManagmentController;

// // Translation
Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang');

// Auth
Route::get('/', [AuthController::class, 'loginPage'])->name('login-page');
Route::get('/printmy/{id}', function($id){
    $document = Document::findOrFail($id);
    $signature_one =$document->signature[0];
    $signature_two =$document->signature[1];
    $data =[
        'document'                      => $document,
        'signature_one'                 => $signature_one,
        'signature_two'                 => $signature_two,
    ];
    return view('admin.docs.printPdf' , $data);
});
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register-page', [AuthController::class, 'registerPage'])->name('register-page');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
// Dashboard

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// User Managment
Route::group(['prefix' => 'user_management'], function () {

    Route::get('/', [UserManagmentController::class, 'index'])->name('admin.user_managment');
    Route::get('/create', [UserManagmentController::class , 'create'])->name('admin.user_managment.create');
    Route::post('/create', [UserManagmentController::class , 'store'])->name('admin.user_managment.store');
    Route::get('/edit/{id}' , [UserManagmentController::class , 'edit'])->name('admin.user_managment.edit');
    Route::patch('/update/{id}' , [UserManagmentController::class , 'update'])->name('admin.user_managment.update');
    Route::get('/delete/{id}', [UserManagmentController::class ,'destroy'])->name('admin.user_managment.delete');

    Route::get('/signature', [UserManagmentController::class, 'signature'])->name('admin.user_management.signature');
    Route::post('/signature/store', [UserManagmentController::class, 'storeSignature'])->name('admin.user_management.store_signature');

});

// Roles
Route::group(['prefix' => 'admin/roles'], function () {
    Route::get('/', [RoleController::class, 'index'])->name('admin.roles');
    Route::get('/create', [RoleController::class, 'create'])->name('admin.roles.create');
    Route::post('/store', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::post('/{id}/update', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::delete('/delete', [RoleController::class, 'destroy'])->name('admin.roles.delete');
});

// Settings

Route::group(['prefix' => 'settings'], function () {

    Route::get('/', [SettingsController::class, 'index'])->name('admin.settings');
    Route::get('/edit/{setting}', [SettingsController::class, 'edit'])->name('admin.settings.edit');
    Route::put('/update/{setting}', [SettingsController::class, 'update'])->name('admin.settings.update');
});

// Departments

Route::group(['prefix' => 'departments'], function () {

    Route::get('/', [DepartmentsController::class, 'index'])->name('all_departments');
    Route::get('/create', [DepartmentsController::class, 'create'])->name('departments.create_department');
    Route::post('/create', [DepartmentsController::class, 'store'])->name('departments.store');
    Route::get('/show/{slug}', [DepartmentsController::class, 'show'])->name('departments.show');
    Route::get('/edit/{id}', [DepartmentsController::class, 'edit'])->name('departments.edit');
    Route::post('/edit/{id}', [DepartmentsController::class, 'update'])->name('departments.update');
    // Route::post('update_top_departments', 'DepartmentsController@update_top_departments')->name('update_top_departments');
    Route::get('/delete/{slug}', [DepartmentsController::class, 'destroy'])->name('departments.delete');

});
Route::group(['prefix' => 'documents'], function () {

    Route::get('/', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('/store', [DocumentController::class, 'store'])->name('documents.store');
    Route::post('/update/{id}', [DocumentController::class, 'update'])->name('documents.update');
    Route::get('/show/{id}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/show_department_documents/{id}', [DocumentController::class, 'show_department_documents'])->name('documents.show_department_documents');
    Route::get('/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::get('/edit/{id}', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::get('/signature/{id}', [DocumentController::class, 'createSignature'])->name('signatures');
    Route::post('/save-signature', [DocumentController::class, 'signature'])->name('save.signatures');
    Route::post('/add_to_department', [DocumentController::class, 'add_to_department'])->name('add_to_department');
    Route::get('/delete/{id}', [DocumentController::class, 'delete'])->name('documents.delete');
    Route::get('/archive/{id}', [DocumentController::class, 'archive'])->name('documents.archive');
    Route::get('/archive', [DocumentController::class, 'main_archive'])->name('documents.main_archive');
    Route::get('/delete_from_archive/{id}', [DocumentController::class, 'delete_archive'])->name('documents.delete_archive');
    Route::get('/follow/{id}', [DocumentController::class, 'follow'])->name('documents.follow');
    Route::get('/external_files', [DocumentController::class, 'external_files'])->name('documents.external');
    Route::post('/external_files/add', [DocumentController::class, 'uploadPdf'])->name('documents.uploadPdf');
    Route::get('/external_files/delete/{id}', [DocumentController::class, 'deletePdf'])->name('documents.external_delete');
    Route::get('/external_files/view/{id}', [DocumentController::class, 'viewPdf'])->name('documents.view');
    Route::get('/print-document-pdf/{id}' , [DocumentController::class , 'printPdf'])->name('documents.print_pdf');

});
// Messages web.send_message

Route::group(['prefix' => 'documents'], function () {

    Route::get('/send_message/{id}', [MessagesController::class, 'send'])->name('messages.send_message');
    Route::post('/send', [MessagesController::class, 'store'])->name('messages.store')->middleware('auth');

});

// Route::resource('folders', FolderController::class);
// Route::post('/update-folder-positions', [FolderController::class, 'updateFolderPositions'])->name('folders.updatePositions');
// Route::post('/update-folder-child-positions', [FolderController::class, 'updateFolderChildPositions'])->name('folders.updateChildPositions');
// Route::post('/folders/details', [FolderController::class, 'fetchDetails'])->name('folders.fetchDetails');
// Route::post('/folders/download-zip', [FolderController::class, 'downloadZip'])->name('folders.downloadZip');
// Route::post('/folders/delete', [FolderController::class, 'deleteSelecetdFolder'])->name('folders.deleteSelecetdFolder');

// Route::get('/document/upload', [DocumentController::class, 'index'])->name('fileRequest.upload');
// Route::post('/request-document', [FileRequestController::class, 'store'])->name('fileRequest.store');
// Route::post('/upload', [DocumentController::class, 'uploadDocumentFiles'])->name('upload');
// Route::post('/change-document', [DocumentController::class, 'changeFile'])->name('changeFile');
// Route::get('/filter-documents-by-tags', [DocumentController::class, 'filterDocumentByTag'])->name('filterDocumentByTag');
// Route::post('/update-document-order', [DocumentController::class, 'updateDocumentOrder'])->name('update.document.order');

// // Tags Route
// Route::resource('tags', TagController::class);
// Route::get('/search-tags', [TagController::class, 'searchTags'])->name('searchTags');
// Route::get('/add-tag', [TagController::class, 'addTag'])->name('addTag');

// Route::get('openfiles', [FilesController::class , 'readAndEditMyFile'])->name('openfiles');

// // Route::get('openfiles' , function(){
// //     $handel = fopen('word.docx');
// //         fread($handel);
// //     fclose($handel);
// // })->name('openfiles');
