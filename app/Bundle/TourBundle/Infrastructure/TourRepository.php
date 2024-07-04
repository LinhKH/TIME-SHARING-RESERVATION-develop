<?php

namespace App\Bundle\TourBundle\Infrastructure;

use App\Bundle\Common\Constants\PaginationConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\CustomerBundle\Domain\Model\CustomerId;
use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\TourBundle\Domain\Model\ChoiceDate;
use App\Bundle\TourBundle\Domain\Model\ITourRepository;
use App\Bundle\TourBundle\Domain\Model\NoReason;
use App\Bundle\TourBundle\Domain\Model\Pagination;
use App\Bundle\TourBundle\Domain\Model\Tour;
use App\Bundle\TourBundle\Domain\Model\TourApproval;
use App\Bundle\TourBundle\Domain\Model\TourId;
use App\Bundle\TourBundle\Domain\Model\TourNonApproval;
use App\Bundle\TourBundle\Domain\Model\TourStatus;
use App\Bundle\TourBundle\Domain\Model\UserViewFlg;
use App\Models\Tour as TourModel;
use DateTime;
use Exception;

class TourRepository implements ITourRepository
{
    /**
     * @param Tour $tour
     * @return TourId
     * @throws InvalidArgumentException
     */
    public function createTour(Tour $tour): TourId
    {
        $entity = new TourModel([
            '4th_choice_date' => $tour->getFourthChoiceDate()->getDate(),
            '4th_choice_time' => $tour->getFourthChoiceDate()->getTime(),
            'checklist' => $tour->getChecklist(),
            'first_choice_date' => $tour->getFirstChoiceDate()->getDate(),
            'first_choice_time' => $tour->getFirstChoiceDate()->getTime(),
            'fix_choice_date_column_name' => $tour->getFixChoiceDateColumnName(),
            'fix_choice_time_column_name' => $tour->getFixChoiceTimeColumnName(),
            'no_reason' => $tour->getNoReason(),
            'organization_id' => $tour->getOrganizationId()->getValue(),
            'rental_space_id' => $tour->getRentalSpaceId()->getValue(),
            'second_choice_date' => $tour->getSecondChoiceDate()->getDate(),
            'second_choice_time' => $tour->getSecondChoiceDate()->getTime(),
            'status' => $tour->getStatus()->getStatus(),
            'third_choice_date' => $tour->getThirdChoiceDate()->getDate(),
            'third_choice_time' => $tour->getThirdChoiceDate()->getTime(),
            'use_plans_date' => $tour->getUsePlansDate(),
            'use_plans_people' => $tour->getUsePlansPeople(),
            'use_purpose' => $tour->getUsePurpose(),
            'use_purpose_detail' => $tour->getUsePurposeDetail(),
            'user_id' => $tour->getCustomerId()->getValue(),
            'user_view_flg' => $tour->getUserViewFlg()->getStatus()
        ]);

        $entity->save();

        return new TourId($entity->id);
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function findAll(): array
    {
        $result = TourModel::paginate(PaginationConst::TOUR_ROW);
        $entities = $result->toArray();
        $tours = [];

        foreach ($entities['data'] as $entity) {
            $tours[] = new Tour(
                new TourId($entity['id']),
                new CustomerId($entity['user_id']),
                new ChoiceDate(
                    new \DateTime($entity['first_choice_date']),
                    new \DateTime($entity['first_choice_time'])
                ),
                new ChoiceDate(
                    !empty($entity['second_choice_date']) ? new \DateTime($entity['second_choice_date']) : null,
                    !empty($entity['second_choice_time']) ? new \DateTime($entity['second_choice_time']) : null
                ),
                new ChoiceDate(
                    !empty($entity['third_choice_date']) ? new \DateTime($entity['third_choice_date']) : null,
                    !empty($entity['third_choice_time']) ? new \DateTime($entity['third_choice_time']) : null
                ),
                new ChoiceDate(
                    !empty($entity['fouth_choice_date']) ? new \DateTime($entity['fouth_choice_date']) : null,
                    !empty($entity['fouth_choice_time']) ? new \DateTime($entity['fouth_choice_time']) : null
                ),
                new ChoiceDate(
                    !empty($entity['substitute_first_choice_date']) ? new \DateTime($entity['substitute_first_choice_date']) : null,
                    !empty($entity['substitute_first_choice_time']) ? new \DateTime($entity['substitute_first_choice_time']) : null
                ),
                new ChoiceDate(
                    !empty($entity['substitute_second_choice_date']) ? new \DateTime($entity['substitute_second_choice_date']) : null,
                    !empty($entity['substitute_second_choice_time']) ? new \DateTime($entity['substitute_second_choice_time']) : null,
                ),
                new ChoiceDate(
                    !empty($entity['substitute_third_choice_date']) ? new \DateTime($entity['substitute_third_choice_date']) : null,
                    !empty($entity['substitute_third_choice_time']) ? new \DateTime($entity['substitute_third_choice_time']) : null
                ),
                new RentalSpaceId($entity['rental_space_id']),
                new OrganizationId($entity['organization_id']),
                $entity['no_reason'],
                TourStatus::fromStatus($entity['status']),
                $entity['use_plans_date'],
                $entity['use_plans_people'],
                $entity['use_purpose'],
                $entity['use_purpose_detail'],
                $entity['checklist'],
                !empty($entity['entry_time']) ? new \DateTime($entity['entry_time']) : null,
                $entity['fix_choice_date_column_name'],
                $entity['fix_choice_time_column_name'],
                UserViewFlg::fromStatus($entity['user_view_flg'])
            );
        }

        $pagination = new Pagination(
            $result->lastPage(),
            $result->perPage(),
            $result->currentPage()
        );

        return [
            $pagination,
            $tours
        ];
    }

    /**
     * @param TourApproval $tourApproval
     * @return TourId
     * @throws InvalidArgumentException
     */
    public function updateTourApproval(TourApproval $tourApproval): TourId
    {
        $tour = TourModel::findOrFail($tourApproval->getTourId()->getValue());

        $tour->update([
            'status' => $tourApproval->getTourStatus()->getStatus(),
            'fix_choice_date_column_name' => $tourApproval->getFixChoiceDate()->getFixChoiceDate(),
            'fix_choice_time_column_name' => $tourApproval->getFixChoiceDate()->getFixChoiceTime()
        ]);

        return new TourId($tour->id);
    }

    /**
     * @param TourNonApproval $tourNonApproval
     * @return TourId
     */
    public function updateTourNonApproval(TourNonApproval $tourNonApproval): TourId
    {
        TourModel::whereId($tourNonApproval->getTourId()->getValue())->update([
            'status' => $tourNonApproval->getTourStatus()->getStatus(),
            'substitute_first_choice_date' => $tourNonApproval->getSubstitudeFirstChoiceDate()->getDate(),
            'substitute_first_choice_time' => $tourNonApproval->getSubstitudeFirstChoiceDate()->getTime(),
            'substitute_second_choice_date' => $tourNonApproval->getSubstitudeSecondChoiceDate()->getDate(),
            'substitute_second_choice_time' => $tourNonApproval->getSubstitudeSecondChoiceDate()->getTime(),
            'substitute_third_choice_date' => $tourNonApproval->getSubstitudeThirdChoiceDate()->getDate(),
            'substitute_third_choice_time' => $tourNonApproval->getSubstitudeThirdChoiceDate()->getTime(),
        ]);

        return $tourNonApproval->getTourId();
    }

    /**
     * @param TourId $tourId
     * @return Tour|null
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function findById(TourId $tourId): ?Tour
    {
        $entity = TourModel::find($tourId->getValue());
        if (empty($entity)) {
            return null;
        }
        $entity = $entity->toArray();
        return new Tour(
            new TourId($entity['id']),
            new CustomerId($entity['user_id']),
            new ChoiceDate(
                new DateTime($entity['first_choice_date']),
                new DateTime($entity['first_choice_time'])
            ),
            new ChoiceDate(
                !empty($entity['second_choice_date']) ? new DateTime($entity['second_choice_date']) : null,
                !empty($entity['second_choice_time']) ? new DateTime($entity['second_choice_time']) : null
            ),
            new ChoiceDate(
                !empty($entity['third_choice_date']) ? new DateTime($entity['third_choice_date']) : null,
                !empty($entity['third_choice_time']) ? new DateTime($entity['third_choice_time']) : null
            ),
            new ChoiceDate(
                !empty($entity['4th_choice_date']) ? new DateTime($entity['4th_choice_date']) : null,
                !empty($entity['4th_choice_time']) ? new DateTime($entity['4th_choice_time']) : null
            ),
            new ChoiceDate(
                !empty($entity['substitute_first_choice_date']) ? new DateTime($entity['substitute_first_choice_date']) : null,
                !empty($entity['substitute_first_choice_time']) ? new DateTime($entity['substitute_first_choice_time']) : null
            ),
            new ChoiceDate(
                !empty($entity['substitute_second_choice_date']) ? new DateTime($entity['substitute_second_choice_date']) : null,
                !empty($entity['substitute_second_choice_time']) ? new DateTime($entity['substitute_second_choice_time']) : null
            ),
            new ChoiceDate(
                !empty($entity['substitute_third_choice_date']) ? new DateTime($entity['substitute_third_choice_date']) : null,
                !empty($entity['substitute_third_choice_time']) ? new DateTime($entity['substitute_third_choice_time']) : null
            ),
            new RentalSpaceId($entity['rental_space_id']),
            new OrganizationId($entity['organization_id']),
            !empty($entity['no_reason']) ? NoReason::fromNoReason($entity['no_reason']) : null,
            TourStatus::fromStatus($entity['status']),
            $entity['use_plans_date'],
            $entity['use_plans_people'],
            $entity['use_purpose'],
            $entity['use_purpose_detail'],
            $entity['checklist'],
            new DateTime($entity['entry_time']),
            $entity['fix_choice_date_column_name'],
            $entity['fix_choice_time_column_name'],
            UserViewFlg::fromStatus($entity['user_view_flg'])
        );
    }
}

