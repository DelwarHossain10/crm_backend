<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PermissionsController;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\UserController;

use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\ZoneController;
use App\Http\Controllers\Api\OrganizationTypeController;
use App\Http\Controllers\Api\InformationSourceController;
use App\Http\Controllers\Api\BusinessIndustryController;
use App\Http\Controllers\Api\DesignationController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\ProfessionController;
use App\Http\Controllers\Api\JobTypeController;
use App\Http\Controllers\Api\GenderController;
use App\Http\Controllers\Api\InfluencingRoleController;
use App\Http\Controllers\Api\KeyAccountPersonController;
use App\Http\Controllers\Api\IndustryTypeController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\ThanaController;
use App\Http\Controllers\Api\WinProbabilityController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\SalesOrderController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\QuotationController;
use App\Http\Controllers\Api\ItemController;

use App\Http\Controllers\IndividualInfoController;
use App\Http\Controllers\OrganizationInfoController;





// Public Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/loggeduser', [UserController::class, 'logged_user']);
    Route::post('/changepassword', [UserController::class, 'change_password']);

    //List
    Route::get('/role_list', [UserController::class, 'role_list']);
    Route::get('/permission_list', [UserController::class, 'permission_list']);
    Route::get('/user_list', [UserController::class, 'user_list']);

    Route::get('/user_show/{id}', [UserController::class, 'show']);

    //User Update
    Route::get('/user_edit/{id}', [UserController::class, 'user_edit']);
    Route::put('/user_update/{id}', [UserController::class, 'user_update']);

    Route::get('/role_wise_user', [UserController::class, 'role_wise_user']);

    //User Update
    Route::put('/user_update/{id}', [UserController::class, 'user_update']);

    //User Delete
    Route::delete('/user_delete/{id}', [UserController::class, 'user_delete']);

    //Assign Permission
    Route::put('/assign_permission/{id}', [UserController::class, 'assign_permission']);

    //role & permission
    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);


    //Setting
    Route::resource('items', ItemController::class);
    Route::get('/all-items-paginated', [ItemController::class, 'allItemPaginated']);
    Route::resource('countries', CountryController::class);
    Route::get('/all-countries-paginated', [CountryController::class, 'allCountryPaginated']);
    Route::resource('zones', ZoneController::class);
    Route::get('/all-zones-paginated', [ZoneController::class, 'allZonePaginated']);
    Route::resource('organization-types', OrganizationTypeController::class);
    Route::get('/all-organization-types-paginated', [OrganizationTypeController::class, 'allOrganizationTypePaginated']);
    Route::resource('information-sources', InformationSourceController::class);
    Route::get('/all-information-sources-paginated', [InformationSourceController::class, 'allInformationSourcePaginated']);
    Route::resource('business-industries', BusinessIndustryController::class);
    Route::get('/all-business-industries-paginated', [BusinessIndustryController::class, 'allBusinessIndustryPaginated']);
    Route::resource('designations', DesignationController::class);
    Route::get('/all-designations-paginated', [DesignationController::class, 'allDesignationPaginated']);
    Route::resource('departments', DepartmentController::class);
    Route::get('/all-departments-paginated', [DepartmentController::class, 'allDepartmentPaginated']);
    Route::resource('professions', ProfessionController::class);
    Route::get('/all-professions-paginated', [ProfessionController::class, 'allProfessionPaginated']);
    Route::resource('job-types', JobTypeController::class);
    Route::get('/all-job-types-paginated', [JobTypeController::class, 'allJobTypePaginated']);
    Route::resource('genders', GenderController::class);
    Route::get('/all-genders-paginated', [GenderController::class, 'allGenderPaginated']);
    Route::resource('influencing-roles', InfluencingRoleController::class);
    Route::get('/all-influencing-roles-paginated', [InfluencingRoleController::class, 'allInfluencingRolePaginated']);
    Route::resource('key-account-persons', KeyAccountPersonController::class);
    Route::get('/all-key-account-persons-paginated', [KeyAccountPersonController::class, 'allKeyAccountPersonPaginated']);
    Route::resource('industry-types', IndustryTypeController::class);
    Route::get('/all-industry-types-paginated', [IndustryTypeController::class, 'allIndustryTypePaginated']);
    Route::resource('divisions', DivisionController::class);
    Route::get('/all-divisions-paginated', [DivisionController::class, 'allDivisionPaginated']);
    Route::resource('districts', DistrictController::class);
    Route::get('/all-districts-paginated', [DistrictController::class, 'allDistrictPaginated']);
    Route::resource('thanas', ThanaController::class);
    Route::get('/all-thanas-paginated', [ThanaController::class, 'allThanaPaginated']);
    Route::resource('win-probabilities', WinProbabilityController::class);
    Route::get('/all-win-probabilities-paginated', [WinProbabilityController::class, 'allWinProbabilityPaginated']);
    Route::resource('items', ItemController::class);
    Route::get('/all-items-paginated', [ItemController::class, 'allItemPaginated']);
    Route::get('/employees', [AttendanceController::class, 'employee_list']);

    // system module
    Route::resource('attendance', AttendanceController::class);
    Route::get('/all-attendance-paginated', [AttendanceController::class, 'allAttendancePaginated']);
    Route::post('/attendance_check_out', [AttendanceController::class, 'check_out']);

    Route::resource('lead', LeadController::class);
    Route::get('/all-lead-paginated', [LeadController::class, 'allLeadPaginated']);

    Route::resource('sales-order', SalesOrderController::class);
    Route::get('/all-sales-order-paginated', [SalesOrderController::class, 'allSalesOrderPaginated']);


    Route::resource('task', TaskController::class);
    Route::get('/all-task-paginated', [TaskController::class, 'allTaskPaginated']);

    Route::resource('quotations', QuotationController::class);
    Route::post('/item-wise-quotations', [QuotationController::class, 'itemWiseQuotation']);
    Route::get('/all-quotations-paginated', [QuotationController::class, 'allQuotationPaginated']);

    Route::resource('supplier', SupplierController::class);
    Route::get('/all-supplier-paginated', [SupplierController::class, 'allSupplierPaginated']);

    Route::apiResource('individualInfo', IndividualInfoController::class);
    Route::apiResource('organizationInfo', OrganizationInfoController::class);


});



