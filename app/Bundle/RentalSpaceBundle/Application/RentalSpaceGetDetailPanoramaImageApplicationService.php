<?php


namespace App\Bundle\RentalSpaceBundle\Application;


use App\Bundle\Common\Constants\MessageConst;
use App\Bundle\Common\Domain\Model\InvalidArgumentException;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\RentalSpaceBundle\Infrastructure\RentalSpaceImageRepository;
use Illuminate\Support\Facades\Storage;

final class RentalSpaceGetDetailPanoramaImageApplicationService
{
    /**
     * @var RentalSpaceImageRepository
     */
    private RentalSpaceImageRepository $rentalSpaceImageRepository;

    /**
     * RentalSpaceGetDetailPanoramaImageApplicationService constructor.
     * @param RentalSpaceImageRepository $rentalSpaceImageRepository
     */
    public function __construct(
        RentalSpaceImageRepository $rentalSpaceImageRepository
    )
    {
        $this->rentalSpaceImageRepository = $rentalSpaceImageRepository;
    }

    /**
     * @throws InvalidArgumentException
     * @throws RecordNotFoundException
     */
    public function handle(RentalSpaceGetDetailPanoramaImageCommand $command): RentalSpaceGetDetailPanoramaImageResult
    {
        $images = $this->rentalSpaceImageRepository->findAllPanoramaImageById(new RentalSpaceId($command->rentalSpaceId));
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
        return new RentalSpaceGetDetailPanoramaImageResult(
            $images->getRentalSpaceId()->getValue(),
            $imageFiles
        );
    }
}
