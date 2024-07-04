<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceImageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use Illuminate\Support\Facades\Storage;

class RentalSpaceGetDetailFloorPlanApplicationService
{
    /**
     * @var IRentalSpaceImageRepository
     */
    private IRentalSpaceImageRepository $rentalSpaceImageRepository;

    /**
     * RentalSpaceGetDetailFloorPlanApplicationService constructor.
     * @param IRentalSpaceImageRepository $rentalSpaceImageRepository
     */
    public function __construct(
        IRentalSpaceImageRepository $rentalSpaceImageRepository
    )
    {
        $this->rentalSpaceImageRepository = $rentalSpaceImageRepository;
    }

    /**
     * @param RentalSpaceGetDetailFloorPlanCommand $command
     * @return RentalSpaceGetDetailFloorPlanResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailFloorPlanCommand $command): RentalSpaceGetDetailFloorPlanResult
    {
        $images = $this->rentalSpaceImageRepository->findAllFloorPlanImageById(new RentalSpaceId($command->rentalSpaceId));
        if (!$images) {
            throw new RecordNotFoundException(MessageConst::NOT_FOUND['message']);
        }
        $imageFiles = [];
        foreach ($images->getImageFiles() as $imageFile) {
            $imageFiles[] = [
                'id' => $imageFile->getImageId(),
                'title' => $imageFile->getTitleImage(),
                'height' => $imageFile->getHeight(),
                'extension' => $imageFile->getExtension(),
                'length' => $imageFile->getLength(),
                'width' => $imageFile->getWidth(),
                'type' => $imageFile->getType()->getValue(),
                'path_image' => Storage::url($imageFile->getPathImage()),
                'order_number' => $imageFile->getOrderNumber()
            ];
        }
        return new RentalSpaceGetDetailFloorPlanResult(
            $images->getRentalSpaceId()->getValue(),
            $imageFiles
        );
    }
}
