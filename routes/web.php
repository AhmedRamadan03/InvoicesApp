<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\InvociesReportController;
use App\Http\Controllers\InvoicAttachmentsController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoicesArchive;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// route for the Invoices
Route::get('invoices', [InvoicesController::class, 'index']);
Route::get('invoices/create', [InvoicesController::class, 'create'])->name('invoice.create');
Route::get('category/{id}', [InvoicesController::class, 'getProducts'])->name('cat.getProducts');
Route::post('invoice/store', [InvoicesController::class, 'store'])->name('invoice.store');
Route::get('edit_invoice/{id}', [InvoicesController::class, 'edit'])->name('invoice.edit');
Route::post('invoice/update', [InvoicesController::class, 'update'])->name('invoice.update');
Route::get('status_show/{id}',[InvoicesController::class, 'show'])->name('status.show');
Route::post('status_update/{id}', [InvoicesController::class , 'statusUpdate'])->name('status.statusUpdate');
Route::post('invoice/destroy', [InvoicesController::class, 'destroy'])->name('invoice.destroy');

Route::get('invoices_unpaid',[InvoicesController::class , 'invoiceUnpaid']);         
Route::get('invoices_paid',[InvoicesController::class , 'invoicePaid']);
Route::get('invoices_partial',[InvoicesController::class , 'invoicePartial']);
Route::get('invoices_archives',[InvoiceArchiveController::class,'index']);
Route::post('invoice_archive',[InvoiceArchiveController::class,'update'])->name('archive.update');
Route::post('invoice_archive_delete',[InvoiceArchiveController::class,'destroy'])->name('archive.destroy');
Route::get('invoices_export' , [InvoicesController::class , 'export']);

Route::get('print_invoice/{id}',[InvoicesController::class , 'printInvoice'])->name('print.printInvoice');

Route::get('invoiceDetails/{id}', [InvoicesDetailsController::class, 'edit'])->name('invoice.edit');
Route::get('view_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'openFile'])->name('invoice.openFile');
Route::get('download/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'download'])->name('invoice.download');
Route::post('delete', [InvoicesDetailsController::class, 'destroy'])->name('file.destroy');
Route::post('InvoiceAttachments', [InvoicAttachmentsController::class, 'store'])->name('file.store');


//route for the cattegories
Route::resource('categories', CategoriesController::class);
Route::post('categories/update', [CategoriesController::class, 'update'])->name('cat.update');
Route::post('categories/destroy', [CategoriesController::class, 'destroy'])->name('cat.destroy');

// route for the products
Route::get('products', [ProductsController::class, 'index'])->name('product.index');
Route::post('products/add', [ProductsController::class, 'store'])->name('product.store');
Route::post('products/update', [ProductsController::class, 'update'])->name('product.update');
Route::post('products/destroy', [ProductsController::class, 'destroy'])->name('product.destroy');
// route for the reports
Route::get('invoices_reports',[InvociesReportController::class,'index']);
Route::post('search_invoices',[InvociesReportController::class,'Search_invoices']);

Route::get('customers_report',[CustomerReportController::class,'index']);
Route::post('search_customers',[CustomerReportController::class ,'Search_customers']);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/{page}', [AdminController::class, 'index'])->name('dash.index');
