<?php

namespace App\Services;

use App\Repositories\Location\LocationRepository;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class LocationServices
{
    protected LocationRepository $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function getListLocation(): array
    {
        try {
            $data = $this->locationRepository->getListLocation();

            return [
                'data' => $data,
                'status' => Response::HTTP_OK
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getDetailLocation($id): array
    {
        $this->locationRepository->findOneById($id);

        try {
            $data = $this->locationRepository->getDetailLocation($id);

            return [
                'data' => $data,
                'status' => Response::HTTP_OK,
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param $dataCreate
     *
     * @return array
     */
    public function createLocation($dataCreate): array
    {
        try {
            $putFile = Storage::putFile('public/location', $dataCreate['file'], 'public');
            $dataCreate['file'] = Storage::url($putFile);

            $result = $this->locationRepository->create($dataCreate);

            return $this->getLocationEntity($result->id);
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param int $id
     * @param array $dataUpdate
     *
     * @return array
     */
    public function updateLocation(int $id, array  $dataUpdate): array
    {
        $this->locationRepository->findOneById($id);

        try {
            if (!empty($dataUpdate['file'])) {
                $putFile = Storage::putFile('public/location', $dataUpdate['file'], 'public');
                $dataUpdate['file'] = Storage::url($putFile);
            }

            if (isset($dataUpdate['name'])) {
                $checkName = $this->locationRepository->handleCheckNameLocation($dataUpdate['name']);
                if (isset($checkName) && $checkName->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' =>  "The name has already been taken."
                    ];
                }
            }

            if (isset($dataUpdate['slug'])) {
                $checkSlug = $this->locationRepository->handleCheckSlugLocation($dataUpdate['slug']);
                if (isset($checkSlug) && $checkSlug->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' => "The slug has already been taken."
                    ];
                }
            }

            $this->locationRepository->updateOneById($id, $dataUpdate);

            return $this->getLocationEntity($id);
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function deleteLocation(int $id): array
    {
        $this->locationRepository->findOneById($id);

        try {
            $this->locationRepository->deleteOneById($id);

            return [
                'id' => $id,
                'status' => Response::HTTP_OK,
            ];
        } catch (Exception $e) {
            return [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'msg' => CommonConstant::MSG_EXISTS,
                "result" => null
            ];
        }
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getLocationEntity(int $id): array
    {
        $data = $this->locationRepository->findOneById($id);

        return [
            'data' => $data->toArray(),
            'status' => Response::HTTP_OK
        ];
    }
}
