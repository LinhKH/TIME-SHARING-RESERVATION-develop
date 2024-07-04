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

final class CustomerManageStatusPutApplicationService
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
     * @param \App\Bundle\CustomerBundle\Application\CustomerManageStatusPutCommand $command command
     * @return \App\Bundle\CustomerBundle\Application\CustomerManageStatusPutResult
     */
    public function handle(CustomerManageStatusPutCommand $command): CustomerManageStatusPutResult
    {
        $customer = $this->customerRepository->findById(new CustomerId($command->customerId));
        if (!$customer) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $customer->setIsActive($command->isActive);

        DB::beginTransaction();
        try {
            $customerId = $this->customerRepository->updateStatus($customer);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw new TransactionException('データがなし');
        }

        return new CustomerManageStatusPutResult(
            $customerId->getValue()
        );
    }
}
