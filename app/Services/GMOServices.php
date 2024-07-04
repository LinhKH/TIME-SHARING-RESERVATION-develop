<?php

namespace App\Services;

use App\Services\ApiServices;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Customer\CustomerRepository;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class GMOServices
{
    protected CustomerRepository $customerRepository;
    protected ApiServices $apiServices;

    public function __construct(
        CustomerRepository $customerRepository,
        ApiServices        $apiServices

    )
    {
        $this->customerRepository = $customerRepository;
        $this->apiServices = $apiServices;
    }

    /**
     * @param $dataString
     * @return array
     */
    public function GMOEnTryTran($dataString,$oderId): array
    {
        $response = $this->callApiGMO(config('app.url_entry_tran'), $dataString);
        if (str_contains($response, 'AccessID') && str_contains($response, 'AccessPass')) {
            $dataConvert = explode('&', $response);
            $dataResult['AccessID'] = explode('=', $dataConvert[0])[1];
            $dataResult['AccessPass'] = explode('=', $dataConvert[1])[1];
            $dataResult['OrderId'] = $oderId;
            return [
                "status" => CommonConstant::SUCCESS_CODE,
                "msg" => CommonConstant::MSG_SUCCESSFUL,
                "data" => $dataResult
            ];
        }
        return [
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'msg' => CommonConstant::MSG_EXISTS,
            "result" => $response
        ];
    }

    /**
     * @param $dataString
     * @return array
     */
    public function GMOExecTran($dataString): array
    {
        $response = $this->callApiGMO(config('app.url_exec_tran'), $dataString);

        if (str_contains($response, 'ACS') && str_contains($response, 'OrderID') && str_contains($response, 'Approve')) {
            $dataConvert = explode('&', $response);
            $dataResult['ACS'] = explode('=', $dataConvert[0])[1];
            $dataResult['OrderID'] = explode('=', $dataConvert[1])[1];
            $dataResult['Forward'] = explode('=', $dataConvert[2])[1];
            $dataResult['Method'] = explode('=', $dataConvert[3])[1];
            $dataResult['PayTimes'] = explode('=', $dataConvert[4])[1];
            $dataResult['Approve'] = explode('=', $dataConvert[5])[1];
            $dataResult['TranID'] = explode('=', $dataConvert[6])[1];
            $dataResult['TranDate'] = explode('=', $dataConvert[7])[1];
            $dataResult['CheckString'] = explode('=', $dataConvert[8])[1];
            return [
                "status" => CommonConstant::SUCCESS_CODE,
                "msg" => CommonConstant::MSG_SUCCESSFUL,
                "data" => $dataResult
            ];
        }
        return [
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'msg' => CommonConstant::MSG_EXISTS,
            "result" => $response
        ];
    }


    /**
     * @param $url
     * @param $dataString
     * @return bool|string
     */
    private function callApiGMO($url, $dataString)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $dataString,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

}
