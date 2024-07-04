<?php

use App\Http\Controllers\Bundle\CustomerBundle\CustomerManagementController;
use App\Http\Controllers\Bundle\Inquiry\InquiryController;
use App\Http\Controllers\Bundle\ReservationBundle\ReservationController;
use App\Http\Controllers\Bundle\TourBundle\TourController;
use App\Http\Controllers\Bundle\Ts\NewsController;
use App\Http\Controllers\GMOController;
use Illuminate\Support\Facades\Route;

Route::get('news/detail/{id}', [NewsController::class, 'getDetailNews']);
Route::get('news/list', [NewsController::class, 'getListNews'])->name('news.client.list');
Route::get('get-list-purpose-of-use', [ReservationController::class, 'getListPurposeOfUse']);

Route::put('customer/update-info-registered', [CustomerManagementController::class, 'handleUpdateInfoRegistered']);

//create inquiry on detail space
Route::group(['prefix' => 'inquiry-space'], function () {
    Route::get('list-reply/spaceId/{spaceId}', [InquiryController::class, 'getListReplySpace'])->where('spaceId', '[0-9]+');
    Route::post('create/spaceId/{spaceId}', [InquiryController::class, 'createInquirySpace'])->where('spaceId', '[0-9]+');
});

Route::group(['middleware' => 'auth:customer'], function () {
    Route::group(['prefix' => 'GMO'], function () {
        Route::post('payment/EntryTran', [GMOController::class, 'entryTranGMO']);
        Route::post('payment/ExecTran', [GMOController::class, 'execTranGMO']);
    });

    Route::group(['prefix' => 'space'], function () {
        Route::post('/tours/{rentalSpaceId}', [TourController::class, 'addAction']);
    });

    Route::group(['prefix' => 'customer'], function () {
        // api customer
        Route::put('update-customer', [CustomerManagementController::class, 'handleUpdateCustomer']);
        Route::get('get-list-address', [CustomerManagementController::class, 'getListAddress']);
        Route::get('get-info-customer', [CustomerManagementController::class, 'getInfoCustomer']);
        Route::get('get-list-tour-of-customer', [CustomerManagementController::class, 'getListTourOfCustomer']);
        Route::get('get-detail-tour-of-customer/{tourId}', [CustomerManagementController::class, 'getDetailTourOfCustomer']);
        Route::put('update-info-card', [CustomerManagementController::class, 'handleUpdateInfoCard']);
        
        // api reservation
        Route::group(['prefix' => 'reservation'], function () {
            Route::get('list', [CustomerManagementController::class, 'getListRervationByCustomer']);
            Route::get('detail/{reservationId}', [CustomerManagementController::class, 'getDetailRervationByCustomer']);
            Route::put('update-status/{id}', [ReservationController::class, 'handleUpdateStatusReservation']);
        });
        
        // api inquiry
        Route::group(['prefix' => 'inquiry'], function () {
            Route::get('list', [InquiryController::class, 'getListInquiryByProduct']);
            Route::get('detail/{id}', [InquiryController::class, 'getDetailInquiry']);
            Route::post('create', [InquiryController::class, 'createInquiry']);
            Route::post('reply/{inquiryId}', [InquiryController::class, 'handleInquiryReply']);
            Route::get('list/reply/{id}', [InquiryController::class, 'getListInquiryReply'])->where('id', '[0-9]+');
            Route::post('update/read/{id}', [InquiryController::class, 'updateIsRead'])->where('id', '[0-9]+');
        });
        /*tour API*/
        Route::group(['prefix' => 'tours'], function () {
            Route::post('add_reply', [TourController::class, 'addNewReplyByCustomer']);
            Route::get('list_reply/{id}', [TourController::class, 'getListReply'])->where('id', '[0-9]+');
            Route::post('update/status/{id}', [TourController::class, 'updateStatusTourByAdmin'])->where('id', '[0-9]+');
            Route::delete('delete/{id}', [TourController::class, 'deleteTour'])->where('id', '[0-9]+');
            Route::put('update/status/{id}', [TourController::class, 'updateStatusTourByCustomer'])->where('id', '[0-9]+');
        });
    });
    // customer booking reservation space
    Route::post('customer/booking-space', [ReservationController::class, 'handelBookingSpace']);

});
