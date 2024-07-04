<?php

namespace App\Services;

use App\Models\Customer;
use App\Repositories\Customer\CustomerRepository;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ConvertUtil
 * @package Core\Util
 */
class CustomerServices
{
    protected CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function getListCustomer($request): array
    {
        try {
            $search = $request->all();
            $data = $this->customerRepository->getListCustomer($search, CommonConstant::PAGINATE_LIMIT_CUSTOMER);

            return [
                'data' => $data,
                'status' => Response::HTTP_OK,
            ];
        } catch (\Throwable $th) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $request
     * @return array
     */
    public function handleFilterCustomer($request): array
    {
        try {
            $email = $request['email'];
            $dataSearch = $this->customerRepository->findOneBy('email', $email);
            if (empty($dataSearch)) {
                return [
                    'status' => 400,
                    'msg' => '会員情報はありません'
                ];
            }
            return $dataSearch->toArray();
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @return array
     */
    public function getListAddress(): array
    {
        $data =  CommonConstant::LIST_ADDRESS_JP_PAGE_UPDATE_CUSTOMER;

        return [
            'data' => $data,
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * @return array
     */
    public function getInfoCustomer(): array
    {
        try {
            $customerId = auth()->user()->id;
            $data = $this->customerRepository->getInfoCustomer($customerId);

            return [
                'data' => $data,
                'status' => Response::HTTP_OK,
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param array $dataUpdate
     * @return array
     */
    public function handleUpdateInfoCard(array $dataUpdate): array
    {
        try {
            $data = $this->customerRepository->updateOneById(auth()->user()->id, $dataUpdate);

            return [
                'data' => $data,
                'status' => Response::HTTP_OK,
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param array $dataUpdate
     *
     * @return array
     */
    public function handleUpdateCustomer(array $dataUpdate): array
    {
        $auth = auth()->user();
        try {
            if (!empty($dataUpdate['password'])) {
                $dataUpdate['password'] = bcrypt($dataUpdate['password']);
            }

            $data = $this->customerRepository->updateOneById($auth->id, $dataUpdate);
            if (!empty($dataUpdate['send_mail'])) {
                $this->handleSendMailToCustomer($auth->email, $dataUpdate);
            }

            return [
                'data' => $data,
                'status' => Response::HTTP_OK,
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param array $dataUpdate
     *
     * @return array
     */
    public function handleUpdateInfoRegistered(array $dataUpdate): array
    {
        $sql = $this->customerRepository->findOneBy('email', $dataUpdate['email']);

        try {

            if (empty($sql)) {
                return [
                    'status' => Response::HTTP_NOT_FOUND,
                    'msg' => CommonConstant::MSG_EXISTS_DATA,
                ];
            }

            $dataUpdate['active'] = Customer::CUSTOMER_STATUS_ACTIVE;
            $this->customerRepository->updateOneById($sql->id, $dataUpdate);

            if (!empty($dataUpdate['send_mail'])) {
                $this->handleSendMailToCustomer($dataUpdate['email'], $dataUpdate);
            }

            return [
                'status' => Response::HTTP_OK,
                'msg' => CommonConstant::MSG_SUCCESSFUL,
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                "result" => null
            ];
        }
    }

    public function handleSendMailToCustomer($email, $data)
    {
        // convert business_structure
        if ($data['business_structure'] == "organization") {
            $data['business_structure'] = "会社・団体";
        } else {
            $data['business_structure'] = "個人";
        }

        // convert gender
        switch ($data['gender']) {
            case 'male':
                $data['gender'] = '男';
                break;
            case 'female':
                $data['gender'] = '女';
                break;
            case 'other':
                $data['gender'] = 'その他';
                break;
            default:
                $data['gender'] = '回答しない';
                break;
        }

        // convert birthday_day_ident
        $year = date("Y", strtotime($data['birthday_day_ident']));
        $month = date("m", strtotime($data['birthday_day_ident']));
        $day = date("d", strtotime($data['birthday_day_ident']));

        $data['birthday_day_ident'] = [
            'year' => $year,
            'month' => $month,
            'day' => $day
        ];

        return Mail::send('mail.SendMailCustomer', ['data' => $data], function ($m) use ($email) {
            $m->to($email)->subject('【TIME SHARING】会員の登録が完了しました');
        });
    }
}
