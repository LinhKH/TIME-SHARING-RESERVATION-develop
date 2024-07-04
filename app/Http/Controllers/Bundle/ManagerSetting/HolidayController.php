<?php


namespace App\Http\Controllers\Bundle\ManagerSetting;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\HolidayServices;
use App\Services\ImportCsvHoliday;
use App\Services\ApiServices;
use App\Http\Controllers\Controller;
use Excel;


class HolidayController extends Controller
{
    protected HolidayServices $holidayServices;
    protected ApiServices $apiServices;

    public function __construct(
        HolidayServices $holidayServices,
        ApiServices     $apiServices
    )
    {
        $this->holidayServices = $holidayServices;
        $this->apiServices = $apiServices;
    }

    public function importCsvHoliday(Request $request): JsonResponse
    {
        $result = Excel::import(new ImportCsvHoliday, request()->file('file'));
        return response()->json($result, 200);
    }

    public function getListHoliday()
    {
        $dataResult = $this->holidayServices->getListNews();
        return response()->json($dataResult, 200);
    }
}

