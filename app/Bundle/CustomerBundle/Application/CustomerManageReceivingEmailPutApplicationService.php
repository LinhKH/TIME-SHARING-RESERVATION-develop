<?php
namespace App\Bundle\CustomerBundle\Application;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\CustomerBundle\Domain\Model\CustomerId;
use App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class CustomerManageReceivingEmailPutApplicationService
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
     * @param \App\Bundle\CustomerBundle\Application\CustomerManageReceivingEmailPutCommand $command command
     * @return \App\Bundle\CustomerBundle\Application\CustomerManageReceivingEmailPutResult
     */
    public function handle(CustomerManageReceivingEmailPutCommand $command): CustomerManageReceivingEmailPutResult
    {
        $customer = $this->customerRepository->findById(new CustomerId($command->customerId));
        if (!$customer) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $customer->setReceivingReservationEmails($command->isReceivingReservationEmail);

        DB::beginTransaction();
        try {
            $customerId = $this->customerRepository->updateReceivingReservationEmail($customer);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('データがなし');
        }

        return new CustomerManageReceivingEmailPutResult(
            $customerId->getValue()
        );
    }
}
