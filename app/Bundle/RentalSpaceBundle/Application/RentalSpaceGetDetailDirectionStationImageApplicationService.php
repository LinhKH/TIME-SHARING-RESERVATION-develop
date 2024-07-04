<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\IRentalSpaceImageRepository;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceImageRepository;
use Illuminate\Support\Facades\Storage;

class RentalSpaceGetDetailDirectionStationImageApplicationService
{
    /**
     * @var IRentalSpaceImageRepository|RentalSpaceImageRepository
     */
    private IRentalSpaceImageRepository $rentalSpaceImageRepository;

    /**
     * RentalSpaceGetDetailDirectionStationImageApplicationService constructor.
     * @param IRentalSpaceImageRepository $rentalSpaceImageRepository
     */
    public function __construct(
        IRentalSpaceImageRepository $rentalSpaceImageRepository
    )
    {
        $this->rentalSpaceImageRepository = $rentalSpaceImageRepository;
    }

    /**
     * @param RentalSpaceGetDetailDirectionStationImageCommand $command
     * @return RentalSpaceGetDetailDirectionStationImageResult
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailDirectionStationImageCommand $command): RentalSpaceGetDetailDirectionStationImageResult
    {
        $images = $this->rentalSpaceImageRepository->findAllDirectionStationImageById(new RentalSpaceId($command->rentalSpaceId));
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
        return new RentalSpaceGetDetailDirectionStationImageResult(
            $images->getRentalSpaceId()->getValue(),
            $imageFiles
        );
    }
}
