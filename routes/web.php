<?php

use App\Http\Controllers\AssignedPmController;
use App\Http\Controllers\MallController;
use App\Http\Controllers\PmSupervisorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PurchasingController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\RevenueHeadController;
use App\Http\Controllers\SalesRequestController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    return view('index');
})->middleware(['auth'])->name('index');


Route::get('test', function () {
    $time = time();
    $unique = uniqid();
    $now = today('GMT+8');
    $storage = storage_path();
    $uiid = Str::isUuid($unique);
    $longtext = 'In the benigging God made the sea and the forest filled with trees up above the world so high';
//    $limit = Str::limit($longtext,10);
    $limit = Str::upper($longtext);
    $random = Str::random(20);

//    $abort = abort(401);
//    $container = app();

    $user = auth()->user();
    $value = cache('key','default');
    $cookie = cookie('name', 'value', $time);
//    dump($user,$value,$cookie);
    $event= event(new $user);

    return $now;















})->middleware(['auth'])->name('projects');


Route::get('sales-malls' ,([MallController::class,'sales_malls']))
    ->middleware(['auth'])->name('sales-malls');
//Route::get('count-malls' ,([MallController::class,'mall_count']))
//    ->middleware(['auth'])->name('count-malls');

Route::get('sales-malls-create' ,([MallController::class,'sales_malls_create']))
    ->middleware(['auth'])->name('sales-malls-create');

Route::post('sales-malls-store',([MallController::class,'sales_malls_store']))
    ->middleware(['auth'])->name('sales-malls-store');

Route::get('sales-malls-edit-{id}' ,([MallController::class,'sales_malls_edit']))
    ->middleware(['auth'])->name('sales-malls-edit');

Route::post('sales-malls-update',([MallController::class,'sales_malls_update']))
    ->middleware(['auth'])->name('sales-malls-update');


//===================================================================================================//
Route::get('sales',([SalesRequestController::class,'sales_index']))
    ->middleware(['auth'])->name('sales');

Route::get('sales-sales-create',([SalesRequestController::class,'sales_create']))
    ->middleware(['auth'])->name('sales-sales-create');

Route::post('sales-sales-store',([SalesRequestController::class,'sales_store']))
    ->middleware(['auth'])->name('sales-sales-store');

Route::get('sales-sales-edit-{id}',([SalesRequestController::class,'sales_edit']))
    ->middleware(['auth'])->name('sales-sales-edit');

Route::post('sales-sales-update',([SalesRequestController::class,'sales_update']))
    ->middleware(['auth'])->name('sales-sales-update');

Route::get('disapproved-sales',([SalesRequestController::class,'sales_disapproved']))
    ->middleware(['auth'])->name('disapproved-sales');

Route::get('sales-uploads-proofs',([SalesRequestController::class,'sales_upload_proofs']))
    ->middleware(['auth'])->name('sales-upload-proofs');

Route::get('sales-uploading-proofs-{id}',([SalesRequestController::class,'sales_uploading_proofs']))
    ->middleware(['auth'])->name('sales-uploading-proofs');

Route::post('sales-uploaded',([SalesRequestController::class,'sales_uploaded']))
    ->middleware(['auth'])->name('sales-uploaded');

Route::get('sales-proposal-status',([SalesRequestController::class,'sales_proposal_status']))
    ->middleware(['auth'])->name('sales-proposal-status');

Route::get('sales-view-proposal-{id}',([SalesRequestController::class,'sales_view_proposal']))
    ->middleware(['auth'])->name('sales-view-proposal');

Route::post('sales-proceed',([SalesRequestController::class,'sales_proceed']))
    ->middleware(['auth'])->name('sales-proceed');



//==================================================================================================//
Route::get('pm-review-sales',([PmSupervisorController::class,'pm_review_sales']))
    ->middleware(['auth'])->name('pm-review-sales');

Route::get('pm-review-{id}',([PmSupervisorController::class,'pm_reviews']))
    ->middleware(['auth'])->name('pm-review');

Route::post('pm-review-approve',([PmSupervisorController::class,'pm_review_approve']))
    ->middleware(['auth'])->name('pm-review-approve');

Route::get('review-projects',([PmSupervisorController::class,'review_projects']))
    ->middleware(['auth'])->name('review-projects');

Route::get('review-design-{id}',([PmSupervisorController::class,'review_design']))
    ->middleware(['auth'])->name('review-design');

Route::post('review-approve-design',([PmSupervisorController::class,'approve_design']))
    ->middleware(['auth'])->name('review-approve-design');

Route::get('review-bidders',([PmSupervisorController::class,'review_bidders']))
    ->middleware(['auth'])->name('review-bidders');

Route::get('review-bidder-{id}',([PmSupervisorController::class,'review_bidder']))
    ->middleware(['auth'])->name('review-bidder');

Route::get('review-select-bidder-{id}',([PmSupervisorController::class,'review_select_bidder']))
    ->middleware(['auth'])->name('review-select-bidder');

Route::post('review-selected-bidder',([PmSupervisorController::class,'review_selected_bidder']))
    ->middleware(['auth'])->name('review-selected-bidder');

//TECHNICAL CHECK

Route::get('review-technicals',([PmSupervisorController::class,'review_technicals']))
    ->middleware(['auth'])->name('review-technicals');

Route::get('review-technical-{id}',([PmSupervisorController::class,'review_technical']))
    ->middleware(['auth'])->name('review-technical');

Route::post('done-review-technical',([PmSupervisorController::class,'done_review_technical']))
    ->middleware(['auth'])->name('done-review-technical');

//Route::get('pm-review-design',([PmSupervisorController::class,'pm_review_design']))
//    ->middleware(['auth'])->name('pm-review-design');
//
//Route::get('pm-review-designs',([PmSupervisorController::class,'pm_review_designs']))
//    ->middleware(['auth'])->name('pm-review-designs');

//=======================================================================================================//

Route::get('assigned-pm',([AssignedPmController::class,'assigned_pm']))
    ->middleware(['auth'])->name('assigned-pm');

Route::get('assigned-pm-{id}',([AssignedPmController::class,'assigned_pm_upload']))
    ->middleware(['auth'])->name('assigned-pm');

Route::post('assigned-pm-uploaded',([AssignedPmController::class,'assigned_pm_uploaded']))
    ->middleware(['auth'])->name('assigned-pm-uploaded');

Route::get('redesign-assigned-pm',([AssignedPmController::class,'redesign_assigned_pm']))
    ->middleware(['auth'])->name('redesign-assigned-pm');
Route::get('redesign-assigned-pm-{id}',([AssignedPmController::class,'redesign_assigned_pm_upload']))
    ->middleware(['auth'])->name('redesign-assigned-pm');
Route::post('redesign-assigned-uploaded',([AssignedPmController::class,'redesign_assigned_uploaded']))
    ->middleware(['auth'])->name('redesign-assigned-uploaded');

Route::get('assigned-project-completion',([AssignedPmController::class,'assigned_project_completion']))
    ->middleware(['auth'])->name('assigned-project-completion');
Route::get('assigned-uploading-{id}',([AssignedPmController::class,'assigned_uploading']))
    ->middleware(['auth'])->name('assigned-uploading');
Route::post('assigned-uploaded',([AssignedPmController::class,'assigned_uploaded']))
    ->middleware(['auth'])->name('assigned-uploaded');


//===============================================================================================================
Route::get('bidding',([PurchasingController::class,'bidding']))
    ->middleware(['auth'])->name('bidding');

Route::get('disapproved-bidding',([PurchasingController::class,'disapproved_bidding']))
    ->middleware(['auth'])->name('disapproved-bidding');

Route::post('rebid-bidding',([PurchasingController::class,'rebid_bidding']))
    ->middleware(['auth'])->name('rebid-bidding');

Route::get('upload-bidding-{id}',([PurchasingController::class,'bidding_upload']))
    ->middleware(['auth'])->name('upload-bidding');

Route::get('upload-disapproved-{id}',([PurchasingController::class,'upload_disapproved']))
    ->middleware(['auth'])->name('upload-disapproved');

Route::post('bidders-uploaded',([PurchasingController::class,'upload_biddings']))
    ->middleware(['auth'])->name('bidders-uploaded');

Route::get('bidding-project-completion',([PurchasingController::class,'bidding_project_completion']))
    ->middleware(['auth'])->name('assigned-project-completion');
Route::get('bidding-uploading-{id}',([PurchasingController::class,'bidding_uploading']))
    ->middleware(['auth'])->name('assigned-uploading');
Route::post('bidding-uploaded',([PurchasingController::class,'bidding_uploaded']))
    ->middleware(['auth'])->name('assigned-uploaded');


//======================================REVENUE CONTROLLER =========================================================================

Route::get('revenue-markups',([RevenueController::class,'revenue_markups']))
    ->middleware(['auth'])->name('revenue-markups');

Route::get('revenue-markup-{id}',([RevenueController::class,'revenue_markup']))
    ->middleware(['auth'])->name('revenue-markup');

Route::post('revenue-marked',([RevenueController::class,'revenue_marked']))
    ->middleware(['auth'])->name('revenue-marked');

Route::get('revenue-disapproved',([RevenueController::class,'revenue_disapproved']))
    ->middleware(['auth'])->name('revenue-disapproved');

Route::get('revenue-disapproved-markup-{id}',([RevenueController::class,'revenue_disapproved_markup']))
    ->middleware(['auth'])->name('revenue-disapproved-markup');

Route::get('revenue-bid-summary',([RevenueController::class,'revenue_bid_summary']))
    ->middleware(['auth'])->name('revenue-bid-summary');

Route::get('revenue-uploading-bid-summary-{id}',([RevenueController::class,'revenue_uploading']))
    ->middleware(['auth'])->name('revenue-uploading-bid-summary');

Route::post('revenue-uploaded-bid-summary',([RevenueController::class,'revenue_uploaded']))
    ->middleware(['auth'])->name('revenue-uploaded-bid-summary');


//===============================REVENUE HEAD CONTROLLERS ===========================================================//
Route::get('revenue-head-markups',([RevenueHeadController::class,'revenue_head_markups']))
    ->middleware(['auth'])->name('revenue-head-markups');

Route::get('revenue-head-markup-{id}',([RevenueHeadController::class,'revenue_head_markup']))
    ->middleware(['auth'])->name('revenue-head-markup');

Route::post('revenue-head-marked',([RevenueHeadController::class,'revenue_head_marked']))
    ->middleware(['auth'])->name('revenue-head-marked');





require __DIR__.'/auth.php';
