<?php

namespace App\Services;

use App\Services\ApiServices;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Holiday\HolidayRepository;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class HolidayServices
{
    protected HolidayRepository $holidayRepository;
    protected ApiServices $apiServices;

    public function __construct(
        HolidayRepository $holidayRepository,
        ApiServices       $apiServices

    )
    {
        $this->holidayRepository = $holidayRepository;
        $this->apiServices = $apiServices;
    }


    public function getListNews(): array
    {
        try {
            $dataResult = null;
            $listHoliday = $this->holidayRepository->findAll();
            if (empty($listHoliday)) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_EXISTS,
                    "result" => $dataResult
                ];
            }
            return $this->convertData($listHoliday->toArray());
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    private function convertData($data): array
    {
        $result = [];
        foreach ($data as $value) {
            $result[$value['year']][] = $value;
        }
        return $result;
    }
}
