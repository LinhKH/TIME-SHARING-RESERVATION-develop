<?php

namespace App\Bundle\ReservationBundle\Infrastructure;

use App\Bundle\Common\Constants\PaginationConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\CustomerBundle\Domain\Model\CustomerId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceRentalPlanRepository;
use App\Bundle\ReservationBundle\Domain\Model\DateOfUse;
use App\Bundle\ReservationBundle\Domain\Model\DateTimeConvert;
use App\Bundle\ReservationBundle\Domain\Model\IReservationRepository;
use App\Bundle\ReservationBundle\Domain\Model\ReservationManage;
use App\Bundle\ReservationBundle\Domain\Model\ReservationCriteria;
use App\Bundle\ReservationBundle\Domain\Model\Pagination;
use App\Bundle\ReservationBundle\Domain\Model\Reservation;
use App\Bundle\ReservationBundle\Domain\Model\ReservationDuplicityCheckIdent;
use App\Bundle\ReservationBundle\Domain\Model\ReservationId;
use App\Bundle\ReservationBundle\Domain\Model\ReservationManageCollection;
use App\Bundle\ReservationBundle\Domain\Model\SettingTimeRange;
use App\Bundle\UserBundle\Domain\Model\UserId;
use App\Models\Reservation as ModelReservation;
use App\Services\CommonConstant;
use DateTime;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReservationRepository implements IReservationRepository
{

    /**
     * Create Reservation plan less
     *
     * @param Reservation $reservation
     * @return ReservationId
     * @throws InvalidArgumentException
     */
    public function createReservationPlanLess(Reservation $reservation): ReservationId
    {
        $reservation = ModelReservation::create([
            'rental_space_id' => $reservation->getRentalSpaceId()->getValue(),
            'duplicity_check_ident' => ReservationDuplicityCheckIdent::newId(),
            'planless' => true,
            'proxy_reservation_type' => $reservation->getReservationPlanLess()->getProxyReservationType()->getValue(),
            'day_ident' => $reservation->getReservationPlanLess()->getDateOfUse()->getDay()->getTimestamp(),
            'planless_start_time' => $reservation->getReservationPlanLess()->getSettingTimeRange()->getStartTime()->format('H:i'),
            'planless_end_time' => $reservation->getReservationPlanLess()->getSettingTimeRange()->getEndTime()->format('H:i'),
            'total_price_before_coupon_sans_tax' => $reservation->getReservationPlanLess()->getTotalPriceOverrideSansTax(),
            'total_price_before_coupon_sans_tax_with_fraction' => $reservation->getReservationPlanLess()->setPriceSansTaxWithFraction(),
            'total_price_override_sans_tax' => $reservation->getReservationPlanLess()->setPriceSansTax(),
            'total_price_override_sans_tax_with_fraction' => $reservation->getReservationPlanLess()->setPriceSansTaxWithFraction(),
            'total_price_sans_tax' => $reservation->getReservationPlanLess()->setPriceSansTax(),
            'total_price_sans_tax_with_fraction' => $reservation->getReservationPlanLess()->setPriceSansTaxWithFraction(),
            'use_purpose_category' => $reservation->getReservationPlanLess()->getUsePurposeCategory(),
            'business_structure' => $reservation->getReservationPlanLess()->getBusinessStructure()->getValue(),
            'people_count' => $reservation->getReservationPlanLess()->getPeopleCount(),
            'use_purpose_for_other' => $reservation->getReservationPlanLess()->getUsePurposeForOther(),
            'limited_discount_price_sans_tax' => $reservation->getReservationPlanLess()->getLimitedDiscountPriceSansTax(),
            'memo_owner' => $reservation->getReservationPlanLess()->getMemoOwner(),
            'memo_customer' => $reservation->getReservationPlanLess()->getMemoCustomer(),
            'customer_id' => $reservation->getCustomerId()->getValue(),
            'user_id' => Auth::user()->id,
            'coupon_discount_sans_tax' => $reservation->getReservationPlanLess()->setCouponSansTax(),
            'coupon_discount_sans_tax_with_fraction' => $reservation->getReservationPlanLess()->setCouponSansTaxWithFraction(),
            'coupon_discount_percentage' => $reservation->getReservationPlanLess()->getDistCount(),
            'coupon_id' => $reservation->getReservationPlanLess()->getCouponDistCount()->getCouponId(),
            'coupon_name' => $reservation->getReservationPlanLess()->getCouponDistCount()->getCouponName(),
            'status' => $reservation->getStatus()->getValue(),
            'creation_time' => time(),
            'cc_charging_fee_sans_tax' => 1,
            'cc_charging_fee_sans_tax_with_fraction' => 1,
            'handling_fee_sans_tax' => 0,
            'handling_fee_sans_tax_with_fraction' => 0,
            'post_to_space_search_form' => 0,
            'reserved_by_google_event' => 0,
            'tax_percentage' => 0,
            'users_receiving_reservation_emails' => 1
        ]);

        return new ReservationId($reservation->id);
    }

    /**
     *  GET all reservation
     *
     * @param ReservationCriteria $pagePaginationCriteria
     * @return array
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function findAll(ReservationCriteria $pagePaginationCriteria): array
    {
        // TODO: Implement findAll() method.
        $entities = ModelReservation::paginate(PaginationConst::PAGINATE_ROW);

        $reservationManages = [];
        foreach ($entities as $entity) {
            $reservationManages[] = new ReservationManage(
                new ReservationId($entity->id),
                $entity->use_purpose_category,
                new DateOfUse(DateTime::createFromFormat('U', $entity->day_ident)),
                new SettingTimeRange(
                    new DateTime($entity->planless_start_time),
                    new DateTime($entity->planless_end_time)
                ),
                $entity->status,
                new DateTimeConvert(DateTime::createFromFormat('U', $entity->creation_time)),
                $entity->coupon_id,
                $entity->coupon_name,
                $entity->coupon_id,
                new CustomerId($entity->customer_id),
                new UserId($entity->user_id),
                new RentalSpaceId($entity->rental_space_id)
            );
        }
        // paginate
        $pagination = new Pagination(
            $entities->lastPage(),
            $entities->perPage(),
            $entities->currentPage()
        );

        return [new ReservationManageCollection($reservationManages), $pagination];
    }

    public function handelBookingSpace($request): array
    {
        try {
            $auth = auth()->user();
            if ($auth->getTable() !== 'customer') {
                return [
                    "data" => null,
                    'status' => Response::HTTP_FORBIDDEN
                ];
            }

            $rentalPlanRepository = new RentalSpaceRentalPlanRepository();
            $listInterval = $rentalPlanRepository->getListIntervalOfPlan($request['rental_space_id'], $request['creation_time']);
            if (!empty($listInterval['item'])) {
                foreach ($listInterval['item'] as $item) {
                    if ($item['start_time_formatted'] == $request['planless_start_time'] || $item['end_time_formatted'] == $request['planless_end_time']) {
                        if (!empty($item['booked'])) {
                            return [
                                'status' => CommonConstant::ERROR_CODE,
                                'msg' => CommonConstant::ERROR_INTERVAL,
                                "result" => null
                            ];
                        }
                    }
                }
            }
            $data = array_merge($request, ['customer_id' => $auth->id, 'duplicity_check_ident' => ReservationDuplicityCheckIdent::newId()]);
            if (!empty($data['payment_method']) && $data['payment_method'] === 'credit-card') {
                $data['status'] = CommonConstant::RESERVARION_STATUS_APPROVED;
            }
            $reservation = ModelReservation::create($data);

            return [
                'data' => $reservation->id,
                'status' => Response::HTTP_OK,
            ];
        } catch (\Exception $e) {
            echo($e->getMessage());
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }
}
