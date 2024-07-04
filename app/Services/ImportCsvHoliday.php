<?php

namespace App\Services;

use App\Models\Holiday;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Symfony\Component\HttpFoundation\Response;

class ImportCsvHoliday implements ToModel, WithStartRow, WithCustomCsvSettings
{

    public function startRow(): int
    {
        return 2;
    }

    public function getCsvSettings(): array
    {
        return [
        ];
    }

    public function model(array $row)
    {
        try {
            /*DB::beginTransaction();*/
            if (!intval($row[0]) || !intval($row[1]) || !intval($row[2])) {
                return [
                    "status" => CommonConstant::ERROR_CODE,
                    "msg" => CommonConstant::MSG_FAIL_SCV,
                    "result" => null
                ];
            }
            $id = $row[0] . $row[1] . $row[2];
            $isCheck = Holiday::find($id);

            if (empty($isCheck)) {
                return new Holiday([
                    'id' => $row[0] . $row[1] . $row[2],
                    'name' => $row[3],
                    'year' => $row[0],
                    'month' => $row[1],
                    'day' => $row[2],
                ]);
            }
            /*DB::commit();*/
        } catch (Exception $e) {
            DB::rollback();
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }
}
