<?php

namespace App\Bundle\CustomerBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\CustomerBundle\Domain\Model\Customer;
use App\Bundle\CustomerBundle\Domain\Model\CustomerType;
use App\Bundle\CustomerBundle\Domain\Model\GenderType;
use App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository;
use App\Bundle\CustomerBundle\Domain\Model\SettingTime;
use App\Models\Customer as ModelsCustomer;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final class CustomerManagePostApplicationService
{
    /**
     * @var ICustomerRepository
     */
    private ICustomerRepository $customerRepository;

    /**
     * @param \App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository $customerRepository $customerRepository
     */
    public function __construct(
        ICustomerRepository $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param \App\Bundle\CustomerBundle\Application\CustomerManagePostCommand $command command
     * @return \App\Bundle\CustomerBundle\Application\CustomerManagePostResult
     */
    public function handle(CustomerManagePostCommand $command): CustomerManagePostResult
    {
        $existingEmail = $this->customerRepository->findByEmail($command->email);

        if ($existingEmail) {
            throw new InvalidArgumentException(MessageConst::EXISTING_EMAIL['message']);
        }
        $customer = new Customer(
            null,
            0,
            CustomerType::fromType(CustomerType::TRANSIENT),
            GenderType::fromType(GenderType::UNSPECIFIED),
            new SettingTime(new DateTime(date("Y-m-d H:i:s"))),
            true,
            true,
            $command->localKey,
            $command->email,
            $command->firstName,
            $command->lastName,
            $command->firstNameKana,
            $command->lastNameKana,
            $command->phoneNumber,
            $command->address,
            $command->birthday ? new SettingTime(new DateTime($command->birthday)) : null
        );

        $customer->setCompanyName($command->companyName);
        $customer->setCompanyNameKana($command->companyNameKana);
        $customer->setFacebookUserId($command->facebookUserId);
        $customer->setNickName($command->nickName);
        $customer->setPassword($command->password);

        DB::beginTransaction();
        try {
            $userId = $this->customerRepository->create($customer);
            $this->updateStatusRegistered($command->email);
            $this->handleSendMailToCustomer($command->email);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('データがなし');
        }

        return new CustomerManagePostResult(
            $userId->getValue()
        );
    }

    public function handleSendMailToCustomer($email)
    {
        return Mail::send('mail.SendMailRegistrationCustomer', ['email' => $email], function ($m) use ($email) {
            $m->to($email)->subject('【TIME SHARING】アカウント本登録のお願い');
        });
    }

    public function updateStatusRegistered($email)
    {
        $sql = ModelsCustomer::where('email', $email)->first();
        if (!empty($sql)) {
            return $sql->update(['active' => ModelsCustomer::CUSTOMER_STATUS_UNCONFIRM]);
        }
    }
}
