<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceImageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use Illuminate\Support\Facades\Storage;

class RentalSpaceGetDetailFacadeImageApplicationService
{
    /**
     * @var IRentalSpaceImageRepository
     */
    private IRentalSpaceImageRepository $rentalSpaceImageRepository;

    /**
     * RentalSpaceGetDetailFacadeImageApplicationService constructor.
     * @param IRentalSpaceImageRepository $rentalSpaceImageRepository
     */
    public function __construct(
        IRentalSpaceImageRepository $rentalSpaceImageRepository
    )
    {
        $this->rentalSpaceImageRepository = $rentalSpaceImageRepository;
    }

    /**
     * @param RentalSpaceGetDetailFacadeImageCommand $command
     * @return RentalSpaceGetDetailFacadeImageResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailFacadeImageCommand $command): RentalSpaceGetDetailFacadeImageResult
    {
        $images = $this->rentalSpaceImageRepository->findAllFacadeImageById(new RentalSpaceId($command->rentalSpaceId));
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
        return new RentalSpaceGetDetailFacadeImageResult(
            $images->getRentalSpaceId()->getValue(),
            $imageFiles
        );
    }
}
