<?php

namespace App\Bundle\CustomerBundle\Infrastructure;

use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Constants\PaginationConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\Pagination;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\CustomerBundle\Domain\Model\Customer;
use App\Bundle\CustomerBundle\Domain\Model\CustomerFilter;
use App\Bundle\CustomerBundle\Domain\Model\CustomerId;
use App\Bundle\CustomerBundle\Domain\Model\CustomerType;
use App\Bundle\CustomerBundle\Domain\Model\GenderType;
use App\Bundle\CustomerBundle\Domain\Model\ICustomerRepository;
use App\Bundle\CustomerBundle\Domain\Model\SettingTime;
use App\Models\Customer as ModelCustomer;
use App\Models\RentalSpaceEav as ModelRentalSpaceEav;
use App\Models\Reservation  as ModelReservation;
use DateTime;

class CustomerRepository implements ICustomerRepository
{
    /**
     * @inheritDoc
     */
    public function findAll(CustomerFilter $customerFilter): array
    {
        if (!empty($customerFilter->getCreatedAt())) {
            $entities = ModelCustomer::orderBy('created_at', $customerFilter->getCreatedAt());
        } else {
            $entities = ModelCustomer::orderBy('id', 'DESC');
        }

        if (!empty($customerFilter->getFirstName())) {
            $entities->where('first_name', 'like', "%{$customerFilter->getFirstName()}%");
        }

        if (!empty($customerFilter->getEmail())) {
            $entities->where('email', 'like', "%{$customerFilter->getEmail()}%");
        }

        if (!empty($customerFilter->getPhoneNumber())) {
            $entities->where('phone_number', 'like', "%{$customerFilter->getPhoneNumber()}%");
        }

        if (!empty($customerFilter->getAddress())) {
            $entities->where('address', 'like', "%{$customerFilter->getAddress()}%");
        }

        if (!empty($customerFilter->getMembershipType())) {
            $entities->whereIn('type', $customerFilter->getMembershipType());
        }

        if (!empty($customerFilter->getEmailStatus())) {
            if ($customerFilter->getEmailStatus() == 'notNull') {
                $entities->whereNotNull('email');
            } elseif ($customerFilter->getEmailStatus() == 'null') {
                $entities->whereNull('email');
            }
        }

        if (!empty($customerFilter->getPhoneNumberStatus())) {
            if ($customerFilter->getPhoneNumberStatus() == 'notNull') {
                $entities->whereNotNull('phone_number');
            } elseif ($customerFilter->getPhoneNumberStatus() == 'null') {
                $entities->whereNull('phone_number');
            }
        }

        if ($customerFilter->getEMailMagazine() !== null) {
            $entities->where('receiving_reservation_emails', $customerFilter->getEMailMagazine());
        }

        if ($customerFilter->getStatus() !== null) {
            $entities->where('active', $customerFilter->getStatus());
        }

        if (!empty($customerFilter->getRegistrationDateStart()) && !empty($customerFilter->getRegistrationDateEnd())) {
            $entities->whereDate('created_at', '>=', $customerFilter->getRegistrationDateStart())
                ->whereDate('created_at', '<=', $customerFilter->getRegistrationDateEnd());
        }

        $entities = $entities->paginate(PaginationConst::PAGINATE_ROW);

        $customers = [];
        foreach ($entities as $entity) {
            $customer = new Customer(
                new CustomerId($entity->id),
                $entity->active,
                CustomerType::fromValue($entity->type),
                GenderType::fromValue($entity->gender),
                new SettingTime(DateTime::createFromFormat('U', $entity->creation_time)),
                (bool)$entity->receiving_reservation_emails,
                (bool)$entity->newsletter_subscribed,
                $entity->local_key,
                $entity->email,
                $entity->first_name,
                $entity->last_name,
                $entity->first_name_kana,
                $entity->last_name_kana,
                $entity->phone_number,
                $entity->address,
                $entity->birthday_day_ident ? new SettingTime(DateTime::createFromFormat('U', $entity->birthday_day_ident)) : null,
            );
            $reservations = $entity->reservation()->getResults();
            $totalPriceSansTax = 0;
            foreach ($reservations as $reservation) {
                $totalPriceSansTax += $reservation->total_price_sans_tax;
            }

            $customer->setNumberOfReviews(count($entity->rentalSpaceReview()->getResults()));
            $customer->setTotalPriceSansTax($totalPriceSansTax);
            $customers[] = $customer;
        }

        $pagination = new Pagination(
            $entities->lastPage(),
            $entities->perPage(),
            $entities->currentPage()
        );

        return [
            $customers,
            $pagination
        ];
    }

    /**
     * @inheritDoc
     */
    public function findById(CustomerId $customerId): ?Customer
    {
        $entity = ModelCustomer::find($customerId->getValue());
        if (!$entity) {
            return null;
        }

        $customer = new Customer(
            new CustomerId($entity->id),
            $entity->active,
            CustomerType::fromValue($entity->type),
            GenderType::fromValue($entity->gender),
            new SettingTime(DateTime::createFromFormat('U', $entity->creation_time)),
            (bool)$entity->receiving_reservation_emails,
            (bool)$entity->newsletter_subscribed,
            $entity->local_key,
            $entity->email,
            $entity->first_name,
            $entity->last_name,
            $entity->first_name_kana,
            $entity->last_name_kana,
            $entity->phone_number,
            $entity->address,
            $entity->birthday_day_ident ? new SettingTime(DateTime::createFromFormat('U', $entity->birthday_day_ident)) : null,
        );
        $customer->setCompanyName($entity->company_name);
        $customer->setCompanyNameKana($entity->company_name_kana);
        $customer->setReceivingReservationEmails($entity->receiving_reservation_emails);
        $customer->setNumberOfReviews(count($entity->rentalSpaceReview()->getResults()));
        $reservations = $entity->reservation()->getResults();
        $totalPriceSansTax = 0;
        foreach ($reservations as $reservation) {
            $totalPriceSansTax += $reservation->total_price_sans_tax;
        }
        $customer->setTotalPriceSansTax($totalPriceSansTax);

        return $customer;
    }

    /**
     * @inheritDoc
     */
    public function create(Customer $customer): ?CustomerId
    {
        $result = ModelCustomer::create([
            'nickName' => $customer->getNickName(),
            'active' => $customer->isActive(),
            'creation_time' => $customer->getCreationTime()->getTimeStamps(),
            'email' => $customer->getEmail(),
            'first_name' => $customer->getFirstName(),
            'last_name' => $customer->getLastName(),
            'first_name_kana' => $customer->getFirstNameKana(),
            'last_name_kana' => $customer->getLastNameKana(),
            'company_name' => $customer->getCompanyName(),
            'company_name_kana' => $customer->getCompanyNameKana(),
            'password' => $customer->getPassword(),
            'gender' => $customer->getGenderType()->getValue(),
            'receiving_reservation_emails' => $customer->isReceivingReservationEmails(),
            'newsletter_subscribed' => $customer->isNewsletterSubscribed(),
            'type' => $customer->getCustomerType()->getValue(),
            'locale_key' => 'ja',
            'facebook_user_id' => $customer->getFacebookUserId(),
            'phone_number' => $customer->getPhoneNumber(),
            'address' => $customer->getAddress(),
            'birthday_day_ident' => $customer->getBirthday() ? $customer->getBirthday()->getTimeStamps() : null,
        ]);
        if (!$result) {
            return null;
        }

        return new CustomerId($result->id);
    }

    /**
     * @inheritDoc
     */
    public function updateStatus(Customer $customer): ?CustomerId
    {
        $customerId = $customer->getCustomerId()->getValue();
        $entity = ModelCustomer::find($customerId);

        $entity->active = $customer->isActive();
        $result = $entity->save();
        if (!$result) {
            return null;
        }

        return new CustomerId($customerId);
    }

    /**
     * @param string $email
     * @return Customer|null
     * @throws InvalidArgumentException
     */
    public function findByEmail(string $email): ?Customer
    {
        $entity = ModelCustomer::where('email', $email)->first();

        if (!$entity) {
            return null;
        }

        return new Customer(
            new CustomerId($entity->id),
            (bool)$entity->isActive,
            CustomerType::fromValue($entity->type),
            GenderType::fromValue($entity->gender),
            new SettingTime(DateTime::createFromFormat('U', $entity->creation_time)),
            (bool)$entity->receiving_reservation_emails,
            (bool)$entity->newsletter_subscribed,
            $entity->local_key,
            $entity->email,
            $entity->first_name,
            $entity->last_name,
            $entity->first_name_kana,
            $entity->last_name_kana,
            $entity->phone_number,
            $entity->address,
            $entity->birthday_day_ident ? new SettingTime(DateTime::createFromFormat('U', $entity->birthday_day_ident)) : null,
        );
    }

    /**
     * @inheritDoc
     */
    public function updateReceivingReservationEmail(Customer $customer): ?CustomerId
    {
        $customerId = $customer->getCustomerId()->getValue();
        $entity = ModelCustomer::find($customerId);

        $entity->receiving_reservation_emails = $customer->isReceivingReservationEmails();
        $result = $entity->save();
        if (!$result) {
            return null;
        }

        return new CustomerId($customerId);
    }

    public function getAllNameSpaceByCustomer(int $customerId)
    {
        $query = ModelReservation::where('customer_id', $customerId)->select(['id', 'rental_space_id'])->get()->unique('rental_space_id');

        $result = [];
        foreach ($query->toArray() as $item) {
            $nameSpace = ModelRentalSpaceEav::where('attribute', 'generalBasicSpaceNameJa')->where('namespace', $item['rental_space_id'])->first();

            if (!empty($nameSpace)) {
                $item['nameSpace'] = $nameSpace->value;
                $result[] = $item;
            }
        }

        return $result;
    }
}
