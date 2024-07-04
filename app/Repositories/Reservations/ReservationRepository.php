<?php

namespace App\Repositories\Reservations;

use App\Models\Reservation;
use App\Repositories\AbstractBaseRepository;

class ReservationRepository extends AbstractBaseRepository
{
    protected $model;

    public function __construct(Reservation $model)
    {
        $this->model = $model;
    }

    /**
     * @param null $search
     * @param int $perPage
     *
     * @return object
     */
    public function getListReservation($search = null, int $perPage): object
    {
        $query = $this->model->with(['rentalSpace', 'user', 'customer', 'trackingLinks']);

        if (!empty($search['byUserBooking']) && $search['byUserBooking'] == 'byUser') {
            $query->where('user_id', $search['idUserBooking']);
        }

        if (!empty($search['byUserBooking'])  && $search['byUserBooking'] == 'byCustomer') {
            $query->where('customer_id', $search['idUserBooking']);
        }

        $query->FilterStatus($search);
        $query->FilterUsePurposeCategory($search);
        $query->FilterUsePurposeForOther($search);
        $query->FilterPrefectures($search);
        $query->FilterProxyReservationType($search);
        $query->FilterFrontendReservationType($search);
        $query->FilterEatingAndDrinkingArrangementConsultation($search);
        $query->FilterViaPrFrame($search);
        $query->FilterTrackingLinkSupenavi($search);
        $query->FilterCouponId($search);
        $query->FilterUserCategory($search);
        $query->FilterReservationId($search);
        $query->FilterCouponName($search);
        $query->FilterEmail($search);
        $query->FilterPhoneNumber($search);
        $query->FilterSpaceName($search);
        $query->FilterRentalSpaceId($search);
        $query->FilterTrackingLinkText($search);
        $query->FilterTrackingReferenceId($search);
        $query->FilterPeopleCount($search);
        $query->FilterScheduledDateOfUsePeriod($search);
        $query->FilterReservationCompletionDatePperiod($search);
        $query->FilterUserId($search);

        $query->orderBy('id', 'DESC');

        $data = $query->paginate($perPage);

        // Filter Space ID Exclusion
        // if (isset($search['space_id_exclusion'])) {
        //     $data = array_filter($data, function ($val) use ($search) {
        //         if (!empty($val['rental_space']['id'])) {
        //             return ($val['rental_space']['id'] !== $search['space_id_exclusion']);
        //         }
        //     });

        //     return $data;
        // }

        return $data;
    }

    /**
     * @param $user
     * @return array
     */
    public function getFirstContractorReservation($user): array
    {
        $query = $this->model->where('user_id', $user->id)->whereNotNull('first_contractor_id')->orderBy('id', 'DESC')->get();

        return $query->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getDetailReservation(int $id): array
    {
        $query = $this->model->whereId($id)->with(['customer', 'rentalSpace', 'user'])->first();

        return $query->toArray();
    }

    /**
     * @param int $customerId
     * @return object
     */
    public function getListRervationByCustomer($customerId, $perPage): object
    {
        $query = $this->model->where('customer_id', $customerId)->with(['user', 'customer', 'trackingLinks']);

        $query->with(['rentalSpace' => function ($query) {
            $query->select('id');
        }]);

        $query->orderBy('id', 'DESC');

        return $query->paginate($perPage);
    }
}
