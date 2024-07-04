<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceRentalPlanGroup
{
    private ?RentalSpaceId $rentalSpaceId;
    private string $planGroupName;
    private ?array $rentalPlans;
    private ?RentalPlanStatusType $status;
    private ?RentalPlanGroupId $planGroupId;

    /**
     * @param RentalSpaceId|null $rentalSpaceId
     * @param RentalPlanGroupId|null $planGroupId
     * @param string $planGroupName
     * @param RentalSpaceRentalPlanInPlanGroup[]|null $rentalPlans
     * @param RentalPlanStatusType|null $status
     */
    public function __construct(
        ?RentalSpaceId $rentalSpaceId,
        ?RentalPlanGroupId $planGroupId,
        string $planGroupName,
        ?array $rentalPlans,
        ?RentalPlanStatusType $status
    ){
        $this->planGroupId = $planGroupId;
        $this->status = $status;
        $this->rentalPlans = $rentalPlans;
        $this->planGroupName = $planGroupName;
        $this->rentalSpaceId = $rentalSpaceId;
    }

    /**
     * @return RentalSpaceId|null
     */
    public function getRentalSpaceId(): ?RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return string
     */
    public function getPlanGroupName(): string
    {
        return $this->planGroupName;
    }

    /**
     * @return RentalSpaceRentalPlanInPlanGroup[]|null
     */
    public function getRentalPlans(): ?array
    {
        return $this->rentalPlans;
    }


    /**
     * @return RentalPlanStatusType|null
     */
    public function getStatus(): ?RentalPlanStatusType
    {
        return $this->status;
    }


    /**
     * @return RentalPlanGroupId|null
     */
    public function getPlanGroupId(): ?RentalPlanGroupId
    {
        return $this->planGroupId;
    }

}
