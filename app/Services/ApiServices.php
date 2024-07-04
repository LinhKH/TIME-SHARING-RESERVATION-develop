<?php
/**
 * Created by PhpStorm.
 * User: sonmh
 * Date: 23/09/2022
 * Time: 15:55 AM
 */

namespace App\Services;

use App\Services\CommonConstant;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiServices
{
    public function responseServerError(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'msg' => CommonConstant::MSG_ERROR_PROCESSING,
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function responseBadRequest(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            "status" => CommonConstant::MISS_PARAM_CODE,
            "msg" => CommonConstant::CHECK_DATA_INPUT,
            "result" => null], Response::HTTP_BAD_REQUEST);
    }

    public function getPaginate($data): array
    {
        return [
            'total' => $data['total'],
            'per_page' => $data['per_page'],
            'current_page' => $data['current_page'],
            'next_page' => $data['current_page'],
            'prev_page' => $data['prev_page_url'],
        ];
    }

    /**
     * @param $file
     * @param $type
     *
     */
    public function postUploadImageStorage($file, $type)
    {
        $allowedFileExtension = ['jpg', 'jpeg', 'png', 'bmp'];
        $extension = $file->getClientOriginalExtension();
        $checkExtension = in_array($extension, $allowedFileExtension);
        if (!$checkExtension) {
            return response()->json(['invalid_file_format'], 422);
        }
        $informationImage = getimagesize($file);
        $path = $file->store('public/images');
        return [
            'name' => explode('/', $path)[2],
            'type' => $type,
            'creation_time' => Carbon::now()->format('Ymd'),
            'width' => $informationImage[0],
            'height' => $informationImage[1],
            'length' => filesize($file), //byte
            'extension' => $extension,
            's3key' => $path
        ];
    }

    /**
     * @return string
     */

    public function generateTrackingCode(): string
    {
        $bytes = openssl_random_pseudo_bytes(6);
        return bin2hex($bytes);
    }

}
