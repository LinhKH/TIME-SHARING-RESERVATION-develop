<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Bundle\CustomerBundle\AuthController as CustomerAuthController;
use App\Http\Controllers\Bundle\CustomerBundle\CustomerManagementController;
use App\Http\Controllers\Bundle\OrganizationBundle\BankAccountController;
use App\Http\Controllers\Bundle\OrganizationBundle\OrganizationController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\NearTransportationController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpaceApprovalController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpaceBookingSystemController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpaceController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpaceEquipmentInformationController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpaceGeneralController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpaceImageController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpacePageAndEmailMessageController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpaceRentalIntervalController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpaceRentalPlanController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpaceReservationOptionTypeController;
use App\Http\Controllers\Bundle\RentalSpaceBundle\RentalSpaceTrackLinkController;
use App\Http\Controllers\Bundle\ReservationBundle\ReservationController;
use App\Http\Controllers\Bundle\SystemConfigBundle\SystemConfigController;
use App\Http\Controllers\Bundle\Ts\NewsController;
use App\Http\Controllers\Bundle\Ts\SliderController;
use App\Http\Controllers\Bundle\Ts\BlogController;
use App\Http\Controllers\Bundle\ManagerSetting\NewsArticleController;
use App\Http\Controllers\Bundle\ManagerSetting\HolidayController;
use App\Http\Controllers\Bundle\ManagerSetting\StaticPageController;
use App\Http\Controllers\Bundle\ManagerSetting\CouponController;
use App\Http\Controllers\Bundle\ManagerSetting\GlobalLinkController;
use App\Http\Controllers\Bundle\ManagerSetting\FooterLinkController;
use App\Http\Controllers\Bundle\ManagerSetting\EquipmentInformationController;
use App\Http\Controllers\Bundle\ManagerSetting\LargeAreaController;
use App\Http\Controllers\Bundle\ManagerSetting\PurposeUseController;
use App\Http\Controllers\Bundle\ManagerSetting\SmallAreaController;
use App\Http\Controllers\Bundle\Inquiry\InquiryController;
use App\Http\Controllers\Bundle\ManagerSetting\LocationController;
use App\Http\Controllers\Bundle\SystemConfigBundle\SystemConfigCsvExportController;
use App\Http\Controllers\Bundle\SystemConfigBundle\SystemConfigEmailTemplateController;
use App\Http\Controllers\Bundle\SystemConfigBundle\SystemConfigSummaryController;
use App\Http\Controllers\Bundle\TransportationBundle\TransportationController;
use App\Http\Controllers\Bundle\UserBundle\UserManagementController;
use App\Http\Controllers\Bundle\TourBundle\TourController;
use App\Http\Controllers\Bundle\Ts\CampaignController;
use App\Http\Controllers\Bundle\Ts\CategorySpaceController;
use App\Http\Controllers\Bundle\Ts\EquipmentCategoriesController;
use App\Http\Controllers\Bundle\Ts\FreeSuppliesController;
use App\Http\Controllers\Bundle\Ts\MunicipalitieController;
use App\Http\Controllers\Bundle\Ts\PaidEquipmentController;
use App\Http\Controllers\Bundle\Ts\PlanController;
use App\Http\Controllers\Bundle\Ts\RollBannerController;
use App\Http\Controllers\Bundle\Ts\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('/user-profile', [AuthController::class, 'userProfile'])->middleware('api');
    Route::post('/change-pass', [AuthController::class, 'changePassWord']);
    Route::get('/user-management', [UserManagementController::class, 'manageAction'])->middleware('auth:api');
    Route::put('reset-password/{email}', [UserManagementController::class, 'handleResetPassword']);
});

Route::group([
    'prefix' => 'customer/auth'
], function () {
    Route::post('/login', [CustomerAuthController::class, 'login']);
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->middleware('auth:customer');
    Route::post('/refresh', [CustomerAuthController::class, 'refresh'])->middleware('auth:customer');
    Route::get('/customer-profile', [CustomerAuthController::class, 'customerProfile'])->middleware('api');
    Route::post('/change-password', [CustomerAuthController::class, 'changePassword'])->middleware('auth:customer');
    Route::post('/customer-manage', [CustomerManagementController::class, 'createCustomer']);
    Route::put('/update-status/{id}', [CustomerManagementController::class, 'updateCustomerStatus']);
    Route::put('/update-receive-email/{id}', [CustomerManagementController::class, 'updateReceivingReservationEmail']);
});

// Route tracking link generate
Route::get('/space/{rentalSpaceId}/{slug}?tck={trackingCode}')->where('slug', '^[a-zA-Z0-9_.-]*$')->name('tracking.top_page');
Route::get('/space/{rentalSpaceId}/{slug}/booking/calendar?tck={trackingCode}')->where('slug', '^[a-zA-Z0-9_.-]*$')->name('tracking.reservation_page');

// Route Location
Route::group(['prefix' => 'admin/location'], function () {
    Route::get('list', [LocationController::class, 'getListLocation'])->name('location.list');
    Route::get('detail/{id}', [LocationController::class, 'getDetailLocation'])->name('location.detail');
    Route::post('create', [LocationController::class, 'createLocation'])->name('location.create');
    Route::put('update/{id}', [LocationController::class, 'updateLocation'])->name('location.update');
    Route::delete('delete/{id}', [LocationController::class, 'deleteLocation'])->name('location.delete');
});

// Route Category Spaces
Route::get('category-spaces/list', [CategorySpaceController::class, 'getListCategorySpaces'])->name('category-spaces.list');
Route::get('category-spaces/detail/{id}', [CategorySpaceController::class, 'getDetailCategorySpaces'])->name('category-spaces.detail');
Route::group(['prefix' => 'admin/category-spaces'], function () {
    Route::post('create', [CategorySpaceController::class, 'createCategorySpaces'])->name('category-spaces.create');
    Route::put('update/{id}', [CategorySpaceController::class, 'updateCategorySpaces'])->name('category-spaces.update');
    Route::delete('delete/{id}', [CategorySpaceController::class, 'deleteCategorySpaces'])->name('category-spaces.delete');
});

// Route Municipalities
Route::get('municipalitie/list', [MunicipalitieController::class, 'getListMunicipalitie'])->name('municipalitie.list');
Route::get('municipalitie/detail/{id}', [MunicipalitieController::class, 'getDetailMunicipalitie'])->name('municipalitie.detail');
Route::group(['prefix' => 'admin/municipalitie'], function () {
    Route::post('create', [MunicipalitieController::class, 'createMunicipalitie'])->name('municipalitie.create');
    Route::put('update/{id}', [MunicipalitieController::class, 'updateMunicipalitie'])->name('municipalitie.update');
    Route::delete('delete/{id}', [MunicipalitieController::class, 'deleteMunicipalitie'])->name('municipalitie.delete');
});

// Route Tag
Route::get('tag/list', [TagController::class, 'getListTag'])->name('tag.list');
Route::get('tag/detail/{id}', [TagController::class, 'getDetailTag'])->name('tag.detail');
Route::group(['prefix' => 'admin/tag'], function () {
    Route::post('create', [TagController::class, 'createTag'])->name('tag.create');
    Route::put('update/{id}', [TagController::class, 'updateTag'])->name('tag.update');
    Route::delete('delete/{id}', [TagController::class, 'deleteTag'])->name('tag.delete');
});

// Route Free Supplies
Route::get('free-supplies/list', [FreeSuppliesController::class, 'getListFreeSupplies'])->name('free-supplies.list');
Route::get('free-supplies/detail/{id}', [FreeSuppliesController::class, 'getDetailFreeSupplies'])->name('free-supplies.detail');
Route::group(['prefix' => 'admin/free-supplies'], function () {
    Route::post('create', [FreeSuppliesController::class, 'createFreeSupplies'])->name('free-supplies.create');
    Route::put('update/{id}', [FreeSuppliesController::class, 'updateFreeSupplies'])->name('free-supplies.update');
    Route::delete('delete/{id}', [FreeSuppliesController::class, 'deleteFreeSupplies'])->name('free-supplies.delete');
});

// Route Plan
Route::get('plan/list', [PlanController::class, 'getListPlan'])->name('plan.list');
Route::get('plan/detail/{id}', [PlanController::class, 'getDetailPlan'])->name('plan.detail');
Route::group(['prefix' => 'admin/plan'], function () {
    Route::post('create', [PlanController::class, 'createPlan'])->name('plan.create');
    Route::put('update/{id}', [PlanController::class, 'updatePlan'])->name('plan.update');
    Route::delete('delete/{id}', [PlanController::class, 'deletePlan'])->name('plan.delete');
});

// Route Equipment Categories
Route::get('equipment-categories/list', [EquipmentCategoriesController::class, 'getListEquipmentCategories'])->name('equipment-categories.list');
Route::get('equipment-categories/detail/{id}', [EquipmentCategoriesController::class, 'getDetailEquipmentCategories'])->name('equipment-categories.detail');
Route::group(['prefix' => 'admin/equipment-categories'], function () {
    Route::post('create', [EquipmentCategoriesController::class, 'createEquipmentCategories'])->name('equipment-categories.create');
    Route::put('update/{id}', [EquipmentCategoriesController::class, 'updateEquipmentCategories'])->name('equipment-categories.update');
    Route::delete('delete/{id}', [EquipmentCategoriesController::class, 'deleteEquipmentCategories'])->name('equipment-categories.delete');
});

// Route Paid Equipment
Route::get('paid-equipment/list', [PaidEquipmentController::class, 'getListPaidEquipment'])->name('paid-equipment.list');
Route::get('paid-equipment/detail/{id}', [PaidEquipmentController::class, 'getDetailPaidEquipment'])->name('paid-equipment.detail');
Route::group(['prefix' => 'admin/paid-equipment'], function () {
    Route::post('create', [PaidEquipmentController::class, 'createPaidEquipment'])->name('paid-equipment.create');
    Route::put('update/{id}', [PaidEquipmentController::class, 'updatePaidEquipment'])->name('paid-equipment.update');
    Route::delete('delete/{id}', [PaidEquipmentController::class, 'deletePaidEquipment'])->name('paid-equipment.delete');
});

// Route Roll Banner
Route::get('roll-banner/list', [RollBannerController::class, 'getListRollBanner'])->name('roll-banner.list');
Route::get('roll-banner/detail/{id}', [RollBannerController::class, 'getDetailRollBanner'])->name('roll-banner.detail');
Route::group(['prefix' => 'admin/roll-banner'], function () {
    Route::post('create', [RollBannerController::class, 'createRollBanner'])->name('roll-banner.create');
    Route::put('update/{id}', [RollBannerController::class, 'updateRollBanner'])->name('roll-banner.update');
    Route::delete('delete/{id}', [RollBannerController::class, 'deleteRollBanner'])->name('roll-banner.delete');
});

// Route Rental Space FE
Route::group(['prefix' => 'rental-spaces'], function () {
    Route::get('list', [RentalSpaceController::class, 'getListRentalSpaceFE']);
    Route::get('list-by-condition', [RentalSpaceController::class, 'getListRentalSpaceByCondition']);
    Route::get('/detail/{rentalSpaceId}/manage', [RentalSpaceController::class, 'detailRentalSpaceManage'])->where('rentalSpaceId', '[0-9]+');
});

// Route rental-spaces and interval reservations
Route::get('admin/rental-spaces/{rentalSpaceId}/rental-plan/{rentalPlanId}/interval-in-this-day/detail', [RentalSpaceRentalIntervalController::class, 'detailRentalIntervalInThisDay'])->where(['rentalPlanId', 'rentalSpaceId'], '[0-9]+');
Route::get('admin/reservations/plan/interval/{spaceId}/{dayIdent}', [ReservationController::class, 'getListIntervalOfPlan'])->where('planId', '[0-9]+');
Route::get('admin/rental-spaces/{rentalSpaceId}/list/rental-plan', [RentalSpaceRentalPlanController::class, 'getRentalPlanByRentalSpaceId'])->where('rentalSpaceId', '[0-9]+');

Route::group(['middleware' => 'auth:api', 'prefix' => 'admin'], function () {
    // Route Customer
    Route::group(['prefix' => 'customer'], function () {
        Route::post('/update_customer/{id}', [CustomerManagementController::class, 'updatePassCustomer']);
        Route::get('/manage', [UserManagementController::class, 'manageAction']);
        Route::post('/manage', [UserManagementController::class, 'addAction']);
        Route::get('/user-manage/{id}', [UserManagementController::class, 'getUser']);
        Route::put('/user-manage/{id}', [UserManagementController::class, 'updateUser']);
        Route::get('/customer-manages', [CustomerManagementController::class, 'getCustomers']);
        // Route::get('/customer-manages', [CustomerManagementController::class, 'getListCustomer']);
        Route::get('/customer-manage/{id}', [CustomerManagementController::class, 'getCustomer']);
        Route::get('filter', [CustomerManagementController::class, 'handleFilterCustomer']);
    });

    // Route Rental Space
    Route::group(['prefix' => 'rental-spaces'], function () {
        // List all Space

        Route::get('/check_use/{id}', [RentalSpaceController::class, 'isCheckUsingSpace'])->where('id', '[0-9]+');

        Route::get('/manage', [RentalSpaceGeneralController::class, 'getRentalSpaceManage']);
        Route::get('/detail/{rentalSpaceId}/manage', [RentalSpaceController::class, 'detailRentalSpaceManage'])->where('rentalSpaceId', '[0-9]+');
        Route::get('manage/search', [RentalSpaceController::class, 'searchAndSortAction']);

        //update rental spaces
        Route::post('update-info/{id}', [RentalSpaceGeneralController::class, 'handleUpdateInfoRentalSpace']);

        // General

        Route::post('/create/general', [RentalSpaceGeneralController::class, 'postRentalSpaceGeneral']);
        Route::get('/detail/{rentalSpaceId}/general', [RentalSpaceGeneralController::class, 'detailRentalSpaceGeneral'])->where('rentalSpaceId', '[0-9]+');
        Route::put('/update/{rentalSpaceId}/general', [RentalSpaceGeneralController::class, 'updateRentalSpaceGeneral'])->where('rentalSpaceId', '[0-9]+');

        // Image
        Route::post('/upload-image-storage', [RentalSpaceImageController::class, 'postUploadImageStorage']);
        Route::post('/remove-image-storage', [RentalSpaceImageController::class, 'removeImageStorage']);
        Route::post('/create/{rentalSpaceId}/images', [RentalSpaceImageController::class, 'postRentalSpaceImages'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/images', [RentalSpaceImageController::class, 'detailRentalSpaceImages'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/panorama-images', [RentalSpaceImageController::class, 'detailRentalSpacePanoramaImages'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/facade-images', [RentalSpaceImageController::class, 'detailRentalSpaceFacadeImages'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/directions-station-images', [RentalSpaceImageController::class, 'detailRentalSpaceDirectionStationImages'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/floor-plan', [RentalSpaceImageController::class, 'detailRentalSpaceFloorPlan'])->where('rentalSpaceId', '[0-9]+');
        Route::delete('/delete/{imageId}/images', [RentalSpaceImageController::class, 'deleteRentalSpaceImage']);
        Route::delete('/delete/{imagePanoramaId}/panorama-images', [RentalSpaceImageController::class, 'deleteRentalSpacePanoramaImage']);
        Route::delete('/delete/{imageFacadeId}/facade-images', [RentalSpaceImageController::class, 'deleteRentalSpaceFacadeImage']);
        Route::delete('/delete/{imageDirectionStationId}/directions-station-images', [RentalSpaceImageController::class, 'deleteRentalSpaceDirectionStationImage']);
        Route::delete('/delete/{imageFloorPlanId}/floor-plan', [RentalSpaceImageController::class, 'deleteRentalSpaceFloorPlanImage']);
        Route::put('/{rentalSpaceId}/update-title-image', [RentalSpaceImageController::class, 'updateRentalSpaceImageWithType'])->where('rentalSpaceId', '[0-9]+');

        // Equipment Information
        Route::post('/create/{rentalSpaceId}/equipment-information', [RentalSpaceEquipmentInformationController::class, 'postEquipmentInformation'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/equipment-information', [RentalSpaceEquipmentInformationController::class, 'detailEquipmentInformation'])->where('rentalSpaceId', '[0-9]+');
        Route::put('/update/{rentalSpaceId}/equipment-information', [RentalSpaceEquipmentInformationController::class, 'updateEquipmentInformation'])->where('rentalSpaceId', '[0-9]+');


        // Booking System
        Route::post('/create/{rentalSpaceId}/booking-system', [RentalSpaceBookingSystemController::class, 'postBookingSystem'])->where('rentalSpaceId', '[0-9]+');
        Route::post('/create/{rentalSpaceId}/booking-system/advanced', [RentalSpaceBookingSystemController::class, 'postBookingSystemAdvanced'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/booking-system', [RentalSpaceBookingSystemController::class, 'detailRentalSpaceBookingSystem'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/booking-system/advanced', [RentalSpaceBookingSystemController::class, 'detailRentalSpaceBookingSystemAdvanced'])->where('rentalSpaceId', '[0-9]+');

        // Reservation Option type
        Route::post('/create/{rentalSpaceId}/reservation-option-type', [RentalSpaceReservationOptionTypeController::class, 'postReservationOptionType'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/reservation-option-type', [RentalSpaceReservationOptionTypeController::class, 'detailReservationOptionType'])->where('rentalSpaceId', '[0-9]+');

        // Rental space rental-plan
        Route::post('/create/{rentalSpaceId}/rental-plan/plan', [RentalSpaceRentalPlanController::class, 'postRentalPlan'])->where('rentalSpaceId', '[0-9]+');
        Route::post('/create/{rentalSpaceId}/tracking-links', [RentalSpaceTrackLinkController::class, 'postRentalSpaceTrackLink'])->where('rentalPlanId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/rental-plan/plan/{rentalPlanId}', [RentalSpaceRentalPlanController::class, 'detailRentalPlan'])->where(['rentalPlanId', 'rentalSpaceId'], '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/tracking-links', [RentalSpaceTrackLinkController::class, 'detailRentalSpaceTrackLink'])->where('rentalPlanId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/tracking-links/{trackingLinkId}', [RentalSpaceTrackLinkController::class, 'detailRentalSpaceTrackLinkById'])->where('rentalPlanId', '[0-9]+');
        Route::put('update-name-tracking-links/{trackingLinkId}', [RentalSpaceTrackLinkController::class, 'updateNameTrackLinkById']);
        Route::put('/update/rental-plan/{rentalPlanId}/plan', [RentalSpaceRentalPlanController::class, 'putRentalPlan'])->where('rentalPlanId', '[0-9]+');

        // Rental space interval
        Route::post('/create/space/{rentalSpaceId}/rental-plan/{rentalPlanId}/interval', [RentalSpaceRentalIntervalController::class, 'postRentalPlanInterval'])->where(['rentalPlanId', 'rentalSpaceId'], '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/rental-plan/interval', [RentalSpaceRentalIntervalController::class, 'detailRentalPlanAndIntervalBySpaceId'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/{rentalSpaceId}/rental-plan/{rentalPlanId}/interval/detail', [RentalSpaceRentalIntervalController::class, 'detailRentalIntervalByPlanId'])->where(['rentalPlanId', 'rentalSpaceId'], '[0-9]+');
        Route::get('/rental-plan/interval/{rentalIntervalId}/detail', [RentalSpaceRentalIntervalController::class, 'detailRentalIntervalById'])->where(['rentalIntervalId', 'rentalSpaceId'], '[0-9]+');
        Route::put('/update/rental-plan/interval', [RentalSpaceRentalIntervalController::class, 'updateRentalInterval']);
        Route::delete('/{rentalSpaceId}/rental-plan/{rentalPlanId}/interval/{rentalIntervalId}/delete', [RentalSpaceRentalIntervalController::class, 'deleteRentalInterval'])->where(['rentalIntervalId', 'rentalSpaceId', 'rentalPlanId'], '[0-9]+');

        // Rental Override
        Route::put('/{rentalSpaceId}/rental-plan/{rentalPlanId}/rental-interval-config-override/post-rental-slots/update', [RentalSpaceRentalIntervalController::class, 'updateRentalIntervalSlotOverride'])->where(['rentalPlanId', 'rentalSpaceId'], '[0-9]+');
        Route::get('/{rentalSpaceId}/rental-plan/{rentalPlanId}/interval-override-in-this-day/detail', [RentalSpaceRentalIntervalController::class, 'detailRentalIntervalOverrideInThisDay'])->where(['rentalPlanId', 'rentalSpaceId'], '[0-9]+');
        Route::delete('/rental-interval/rental-interval-override/delete', [RentalSpaceRentalIntervalController::class, 'deleteRentalIntervalOverride']);

        // Rental slot cache entry
        Route::get('/{rentalSpaceId}/rental-plan/{rentalPlanId}/rental-slot-cache-entry-in-this-day/detail', [RentalSpaceRentalIntervalController::class, 'detailRentalSpaceRentalSlotIntervalCacheEntryInThisDay'])->where(['rentalPlanId', 'rentalSpaceId'], '[0-9]+');
        Route::get('/{rentalSpaceId}/rental-plan/{rentalPlanId}/rental-slot-unavailable-cache-entry-in-this-day/detail', [RentalSpaceRentalIntervalController::class, 'detailRentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDay'])->where(['rentalPlanId', 'rentalSpaceId'], '[0-9]+');


        // Rental space plan group
        Route::post('/create/{rentalSpaceId}/rental-plan/group', [RentalSpaceRentalPlanController::class, 'postPlanGroup'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/{rentalSpaceId}/list/rental-plan/group', [RentalSpaceRentalPlanController::class, 'getRentalPlanGroupAll'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/rental-plan/group/{rentalPlanGroupId}', [RentalSpaceRentalPlanController::class, 'detailRentalPlanGroup'])->where('rentalPlanGroupId', '[0-9]+');
        Route::put('/update/rental-plan/group/{rentalPlanGroupId}', [RentalSpaceRentalPlanController::class, 'updatePlanGroup'])->where('rentalPlanGroupId', '[0-9]+');

        // Rental Space Page and Email Message
        Route::post('/create/{rentalSpaceId}/page-and-email-message', [RentalSpacePageAndEmailMessageController::class, 'postRentalSpacePageAndEmailMessage'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/page', [RentalSpacePageAndEmailMessageController::class, 'detailRentalSpacePage'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/email-message', [RentalSpacePageAndEmailMessageController::class, 'detailRentalSpaceEmailMessage'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/email-message/{rentalSpaceId}/manage', [RentalSpacePageAndEmailMessageController::class, 'detailAllRentalSpaceEmailMessage', '[0-9]+']);
        Route::get('/page-and-email-message/{pageAndEmailId}/view', [RentalSpacePageAndEmailMessageController::class, 'getDetailPageAndEmailMessage'])->where('pageAndEmailId', '[0-9]+');
        Route::put('/update/{pageId}/page', [RentalSpacePageAndEmailMessageController::class, 'updateRentalSpacePage'])->where('pageId', '[0-9]+');
        Route::put('/update/{emailMessageId}/email-message', [RentalSpacePageAndEmailMessageController::class, 'updateRentalSpaceEmailMessage']);

        // Rental Space Approval
        Route::put('/{rentalSpaceId}/approval', [RentalSpaceApprovalController::class, 'putRentalSpaceApproval'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/detail/{rentalSpaceId}/approval', [RentalSpaceApprovalController::class, 'detailRentalSpaceApproval'])->where('rentalSpaceId', '[0-9]+');

        // Rental Space Get Current Draft Step
        Route::get('/{rentalSpaceId}/current-draft-step', [RentalSpaceGeneralController::class, 'getCurrentStep'])->where('rentalSpaceId', '[0-9]+');

        // Manage tour
        Route::group(['prefix' => 'tour'], function () {
            Route::get('/manage', [TourController::class, 'manageAction']);
            Route::put('/manage/{tourId}/confirm', [TourController::class, 'putTourApproval'])->where('tourId', '[0-9]+');
            Route::put('/manage/{tourId}/ignore', [TourController::class, 'putTourNonApproval'])->where('tourId', '[0-9]+');
            Route::get('/view/{tourId}', [TourController::class, 'getTourDetail'])->where('tourId', '[0-9]+');
            Route::get('/setting', [TourController::class, 'manageSettingAction']);
            Route::put('/setting/update', [TourController::class, 'updateSettingAction']);
            Route::post('update/status/{id}', [TourController::class, 'updateStatusTourByAdmin'])->where('id', '[0-9]+');
            Route::post('add_reply', [TourController::class, 'addNewReplyByAdmin']);
            Route::get('list_reply/{id}', [TourController::class, 'getListReply'])->where('id', '[0-9]+');
        });

        // Rental space page
        Route::group(['prefix' => 'page'], function () {
            Route::get('/{rentalSpaceId}/manage', [RentalSpacePageAndEmailMessageController::class, 'getAllRentalSpacePage'])->where('rentalSpaceId', '[0-9]+');
        });

        // Near transportation
        Route::post('/{rentalSpaceId}/near-by-transportation', [NearTransportationController::class, 'addOrUpdateNearTransportation'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/{rentalSpaceId}/transport/list', [NearTransportationController::class, 'getNearTransportation'])->where('rentalSpaceId', '[0-9]+');
        Route::delete('/{rentalSpaceId}/transport/{nearTransportationId}', [NearTransportationController::class, 'deleteNearTransportation'])->where(['rentalSpaceId', 'nearTransportationId'], '[0-9]+');
    });

    //Route Organization/Company
    Route::group(['prefix' => 'organization'], function () {
        Route::post('/add', [OrganizationController::class, 'addAction']);
        Route::get('/view/{id}', [OrganizationController::class, 'viewAction']);
        Route::get('/{organizationId}/bank-account/all', [BankAccountController::class, 'getAllBankAccount'])->where('organizationId', '[0-9]+');
    });

    Route::group(['prefix' => 'configuration'], function () {
        Route::put('/system-config/manage', [SystemConfigController::class, 'updateAction']);
        Route::get('/system-config/manage', [SystemConfigController::class, 'viewAction']);

        Route::group(['prefix' => 'rental-space-compilation'], function () {
            Route::post('/add', [SystemConfigSummaryController::class, 'addSummaryAction']);
            Route::get('/manage', [SystemConfigSummaryController::class, 'manageSummaryAction']);
            Route::get('/{rentalSpaceCompilationId}/detail', [SystemConfigSummaryController::class, 'detailSummaryAction'])->where('rentalSpaceCompilationId', '[0-9]+');
            Route::delete('/{rentalSpaceCompilationId}/delete', [SystemConfigSummaryController::class, 'deleteSummaryAction'])->where('rentalSpaceCompilationId', '[0-9]+');
            Route::put('/{rentalSpaceCompilationId}/update', [SystemConfigSummaryController::class, 'updateSummaryAction'])->where('rentalSpaceCompilationId', '[0-9]+');
            Route::post('/{rentalSpaceCompilationId}/upload-images', [SystemConfigSummaryController::class, 'uploadImageSummaryAction'])->where('rentalSpaceCompilationId', '[0-9]+');
            Route::delete('/images/{rentalSpaceCompilationImageId}/delete', [SystemConfigSummaryController::class, 'removeImageSummaryAction']);
            Route::put('/images/{rentalSpaceCompilationImageId}/update', [SystemConfigSummaryController::class, 'updateImageSummaryAction']);
        });
    });

    Route::group(['prefix' => 'reservations'], function () {
        Route::post('/rental-space/{rentalSpaceId}/booking/plan-less', [ReservationController::class, 'postReservationPlanLess'])->where('rentalSpaceId', '[0-9]+');
        Route::get('/manage', [ReservationController::class, 'getAllReservation']);
        Route::get('list', [ReservationController::class, 'getListReservation']);
        Route::get('first-contractor-reservation', [ReservationController::class, 'getFirstContractorReservation']);
        Route::get('detail/{id}', [ReservationController::class, 'getDetailReservation']);
        Route::get('export-reservation', [ReservationController::class, 'handleExportReservation']);
        Route::get('export-first-contractor-reservation', [ReservationController::class, 'handleExportFirstContractorReservation']);
        Route::get('get-list-status-reservation', [ReservationController::class, 'getListStatusReservation']);
        Route::get('get-list-purpose-of-use', [ReservationController::class, 'getListPurposeOfUse']);
        Route::get('get-list-frontend-reservation-type', [ReservationController::class, 'getListFrontendReservationType']);
        Route::get('get-list-reservation-type', [ReservationController::class, 'getListReservationType']);
        Route::put('update-status/{id}', [ReservationController::class, 'handleUpdateStatusReservation']);
    });

    /*inquiry*/
    Route::group(['prefix' => 'inquiry'], function () {
        Route::get('list', [InquiryController::class, 'getListInquiryByProduct']);
        Route::get('detail/{id}', [InquiryController::class, 'getDetailInquiry']);
        Route::post('reply/{inquiryId}', [InquiryController::class, 'handleInquiryReply']);
        Route::get('export', [InquiryController::class, 'handleExportInquiry']);
        Route::get('list/reply/{id}', [InquiryController::class, 'getListInquiryReply'])->where('id', '[0-9]+');
        Route::post('update/status/{id}', [InquiryController::class, 'updateStatusInquiry'])->where('id', '[0-9]+');
        Route::post('update/read/{id}', [InquiryController::class, 'updateIsRead'])->where('id', '[0-9]+');
    });


    Route::group(['prefix' => 'manager-setting'], function () {
        /*news article*/
        Route::post('/news/create', [NewsArticleController::class, 'createNewsArticle']);
        Route::post('/news/update/{newsId}', [NewsArticleController::class, 'updateNewsArticle']);
        Route::get('/news/list_news', [NewsArticleController::class, 'getListNews']);
        Route::delete('/news/{newsId}', [NewsArticleController::class, 'deleteNews'])->where('newsId', '[0-9]+');
        Route::get('/news/detail/{newsId}', [NewsArticleController::class, 'getNewsDetail'])->where('newsId', '[0-9]+');

        /*static page Article*/

        Route::post('/static-page/create', [StaticPageController::class, 'createStaticPageArticle']);
        Route::post('/static-page/update/{pageId}', [StaticPageController::class, 'updateStaticPageArticle']);
        Route::get('/static-page/list-static-page', [StaticPageController::class, 'getListStaticPage']);
        Route::delete('/static-page/delete/{pageId}', [StaticPageController::class, 'deleteStaticPage']);
        Route::get('/static-page/detail/{id}', [StaticPageController::class, 'getDetail']);

        /*holiday*/

        Route::post('/holiday/import-csv', [HolidayController::class, 'importCsvHoliday']);
        Route::get('/holiday/list_holiday', [HolidayController::class, 'getListHoliday']);

        /*Coupon*/
        Route::post('/coupon/create', [CouponController::class, 'createCoupon']);
        Route::post('/coupon/update/{id}', [CouponController::class, 'updateCoupon'])->where('id', '[0-9]+');
        Route::get('/coupon/detail/{id}', [CouponController::class, 'getDetailCoupon'])->where('id', '[0-9]+');
        Route::get('/coupon/list_coupon', [CouponController::class, 'getListCoupon']);
        Route::get('coupon/filter', [CouponController::class, 'handleFilterCoupon']);
        Route::delete('/coupon/delete/{id}', [CouponController::class, 'delete'])->where('id', '[0-9]+');

        /*Global track link*/
        Route::post('/global_link/create', [GlobalLinkController::class, 'creatGlobalLink']);
        Route::post('/global_link/update/{id}', [GlobalLinkController::class, 'update'])->where('id', '[0-9]+');
        Route::get('/global_link/detail/{id}', [GlobalLinkController::class, 'getDetailGlobalLink'])->where('id', '[0-9]+');
        Route::get('/global_link/list_global_link', [GlobalLinkController::class, 'getListGlobalLink']);

        /*Footer Link*/
        Route::post('/footer_link/create', [FooterLinkController::class, 'createFooterLink']);
        Route::post('/footer_link/update/{id}', [FooterLinkController::class, 'updateFooterLink']);
        Route::get('/footer_link/list_by_cat/{category_id}', [FooterLinkController::class, 'getListFooterLinkByCategory']);
        Route::get('/footer_link/detail/{id}', [FooterLinkController::class, 'getDetailFooterLink'])->where('id', '[0-9]+');
        Route::delete('/footer_link/delete/{id}', [FooterLinkController::class, 'deleteFooterLink'])->where('id', '[0-9]+');
        Route::delete('/footer_link/category/delete/{id}', [FooterLinkController::class, 'deleteCategoryFooterLink'])->where('id', '[0-9]+');


        Route::post('/footer_link/category/create', [FooterLinkController::class, 'createCategoryFooterLink']);
        Route::post('/footer_link/category/update/{id}', [FooterLinkController::class, 'updateCategoryFooterLink'])->where('id', '[0-9]+');
        Route::get('/footer_link/category/list', [FooterLinkController::class, 'getListCategoryFooterLink']);
        Route::get('/footer_link/category/detail/{id}', [FooterLinkController::class, 'getDetailCategoryFooterLink'])->where('id', '[0-9]+');

        /*Equipment Information*/
        Route::get('/equipment-information/list-category', [EquipmentInformationController::class, 'getListCategory']);
        Route::post('/equipment-information/create/{categoryId}', [EquipmentInformationController::class, 'createEquipmentInformation']);
        Route::post('/equipment-information/update/{id}', [EquipmentInformationController::class, 'updateEquipmentInformation'])->where('id', '[0-9]+');
        Route::get('/equipment-information/detail/{id}', [EquipmentInformationController::class, 'getDetail'])->where('id', '[0-9]+');
        Route::get('/equipment-information/list/{category_id}', [EquipmentInformationController::class, 'getListEquipmentInformationByCategory'])->where('id', '[0-9]+');
        Route::delete('/equipment-information/delete/{id}', [EquipmentInformationController::class, 'delete'])->where('id', '[0-9]+');
        Route::post('/equipment-information/upload-img/{id}', [EquipmentInformationController::class, 'uploadImageEquipmentInformation']);
        Route::get('/equipment-information/list', [EquipmentInformationController::class, 'getListEquipment']);
        Route::delete('/equipment-information/delete/img/{id}', [EquipmentInformationController::class, 'deleteImgEquipment']);
        // Csv Export
        Route::post('/csv-export/update', [SystemConfigCsvExportController::class, 'updateConfigCsvExport']);
        Route::get('/csv-export/list-target', [SystemConfigCsvExportController::class, 'getListTargetConfigCsvExport']);
        Route::get('/csv-export/detail/{target}', [SystemConfigCsvExportController::class, 'getDetailConfigCsvExportByTarget']);

        /*Purpose Use*/
        Route::post('/purpose-use/create/{categoryId}', [PurposeUseController::class, 'createPurposeUse']);
        Route::post('/purpose-use/update/{id}', [PurposeUseController::class, 'updatePurposeUse'])->where('id', '[0-9]+');
        Route::get('/purpose-use/detail/{id}', [PurposeUseController::class, 'getDetail'])->where('id', '[0-9]+');
        Route::get('/purpose-use/list-by-category/{category_id}', [PurposeUseController::class, 'getListByCategory']);
        Route::delete('/purpose-use/delete/{id}', [PurposeUseController::class, 'deletePurposeUse'])->where('id', '[0-9]+');

        Route::post('/purpose-use/img-upload/{id}', [PurposeUseController::class, 'uploadImagePurposeUse'])->where('id', '[0-9]+');
        Route::post('/purpose-use/img-update/{id}', [PurposeUseController::class, 'updateImgPurpose']);
        Route::delete('/purpose-use/img-delete/{id}', [PurposeUseController::class, 'deleteImgPurpose']);
        Route::get('/purpose-use/img/list/{id}', [PurposeUseController::class, 'getListImagePurposeUse'])->where('id', '[0-9]+');
        Route::get('/purpose-use/list', [PurposeUseController::class, 'getListPurposeUse']);

        // Route SmallArea
        Route::group(['prefix' => 'small-area'], function () {
            Route::get('list', [SmallAreaController::class, 'getListSmallArea'])->name('small_area.list');
            Route::post('create', [SmallAreaController::class, 'createSmallArea'])->name('small_area.create');
            Route::get('detail/{id}', [SmallAreaController::class, 'getDetailSmallArea'])->name('small_area.detail');
            Route::put('update/{id}', [SmallAreaController::class, 'updateSmallArea'])->name('small_area.update');
            Route::delete('delete/{id}', [SmallAreaController::class, 'deleteSmallArea'])->name('small_area.delete');
        });
        // Email Template
        Route::post('/email-template/create', [SystemConfigEmailTemplateController::class, 'createEmailTemplate']);
        Route::get('/email-template/{emailTemplateId}', [SystemConfigEmailTemplateController::class, 'detailEmailTemplate'])->where('emailTemplateId', '[0-9]+');
        Route::get('/email-template/all', [SystemConfigEmailTemplateController::class, 'listEmailTemplate']);
        Route::put('/email-template/{emailTemplateId}', [SystemConfigEmailTemplateController::class, 'updateEmailTemplate'])->where('emailTemplateId', '[0-9]+');
        Route::delete('/email-template/{emailTemplateId}', [SystemConfigEmailTemplateController::class, 'deleteEmailTemplate'])->where('emailTemplateId', '[0-9]+');

        // Route LargeArea
        Route::group(['prefix' => 'large-area'], function () {
            Route::get('list', [LargeAreaController::class, 'getListLargeArea'])->name('large_area.list');
            Route::post('create', [LargeAreaController::class, 'createLargeArea'])->name('large_area.create');
            Route::get('detail/{id}', [LargeAreaController::class, 'getDetailLargeArea'])->name('large_area.detail');
            Route::put('update/{id}', [LargeAreaController::class, 'updateLargeArea'])->name('large_area.update');
            Route::delete('delete/{id}', [LargeAreaController::class, 'deleteLargeArea'])->name('large_area.delete');
        });
    });

    Route::group(['prefix' => 'news'], function () {
        Route::post('/create', [NewsController::class, 'createNews'])->name('news.create');
        Route::put('/update/{id}', [NewsController::class, 'updateNews'])->name('news.update')->where('id', '[0-9]+');
        Route::get('/list', [NewsController::class, 'getListNews'])->name('news.admin.list');
    });


    Route::group(['prefix' => 'slider'], function () {
        Route::post('/create', [SliderController::class, 'createSlider'])->name('slider.create');
        Route::put('/update/{id}', [SliderController::class, 'updateSlider'])->name('slider.update')->where('id', '[0-9]+');
        Route::get('/detail/{id}', [SliderController::class, 'getDetailSlider'])->name('slider.detail.list')->where('id', '[0-9]+');
        Route::get('/list', [SliderController::class, 'getListSlider'])->name('slider.admin.list');
        Route::get('/delete', [SliderController::class, 'deleteSlider'])->name('slider.delete');
    });


    Route::group(['prefix' => 'blog'], function () {
        Route::post('/create', [BlogController::class, 'createBlog'])->name('blog.create');
        Route::put('/update/{id}', [BlogController::class, 'updateBlog'])->name('blog.update')->where('id', '[0-9]+');
        Route::get('/detail/{id}', [BlogController::class, 'getDetailBlog'])->name('blog.detail.detail')->where('id', '[0-9]+');
        Route::get('/list', [BlogController::class, 'getListBlog'])->name('blog.admin.list');
        Route::get('/delete', [BlogController::class, 'deleteSlider'])->name('blog.delete');
    });

    /*blog type*/
    Route::group(['prefix' => 'blog_type'], function () {
        Route::post('/create', [BlogController::class, 'createBlogType'])->name('blog.type.create');
        Route::put('/update/{id}', [BlogController::class, 'updateBlogType'])->name('blog.type.update');
        Route::get('/list', [BlogController::class, 'getListBlogType'])->name('blog.type.list');
        Route::get('/detail/{id}', [BlogController::class, 'getDetailBlogType'])->name('blog.type.detail');
        Route::post('/delete', [BlogController::class, 'deleteBlogType'])->name('blog.type.delete');
    });


    // Route Transportation
    Route::group(['prefix' => 'transportations'], function () {
        Route::get('/suggest/transport', [TransportationController::class, 'suggestTransport']);
    });

    // Route Ts Campaign
    Route::group(['prefix' => 'ts-campaign'], function () {
        Route::get('list', [CampaignController::class, 'getListTsCampaign'])->name('ts_campaign.list');
        Route::get('detail/{id}', [CampaignController::class, 'getDetailTsCampaign'])->name('ts_campaign.detail');
        Route::post('create', [CampaignController::class, 'createTsCampaign'])->name('ts_campaign.create');
        Route::post('update/{id}', [CampaignController::class, 'updateTsCampaign'])->name('ts_campaign.update');
        Route::delete('delete/{id}', [CampaignController::class, 'deleteTsCampaign'])->name('ts_campaign.delete');
        Route::get('schedule/{space_id}', [CampaignController::class, 'getScheduleBySpace'])->name('ts_campaign.schedule');
    });
});
Route::get('ts-campaign/list', [CampaignController::class, 'getListTsCampaign'])->name('ts_campaign.list.fe');
Route::get('ts-campaign/detail/{id}', [CampaignController::class, 'getDetailTsCampaign'])->name('ts_campaign.detail.fe');
require_once('customer.php');
