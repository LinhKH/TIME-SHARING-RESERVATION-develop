<?php

namespace App\Services\Ts;

use App\Repositories\Ts\MunicipalitieRepository;
use App\Services\CommonConstant;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class MunicipalitiServices
{
    protected MunicipalitieRepository $municipalitieRepository;

    public function __construct(MunicipalitieRepository $municipalitieRepository)
    {
        $this->municipalitieRepository = $municipalitieRepository;
    }

    /**
     * @param $request
     *
     * @return array
     */
    public function getListMunicipalitie($request): array
    {
        try {
            $filter = $request->all();
            $data = $this->municipalitieRepository->getListMunicipalitie($filter, CommonConstant::PAGINATE_LIMIT_MUNICIPALITIE_WP);

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
    public function getDetailMunicipalitie(int $id): array
    {
        $this->municipalitieRepository->findOneById($id);

        try {
            $data = $this->municipalitieRepository->getDetailMunicipalitie($id);

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
    public function createMunicipalitie($dataCreate): array
    {
        try {
            $putFile = Storage::putFile('public/category-spaces', $dataCreate['file'], 'public');
            $dataCreate['file'] = Storage::url($putFile);

            $result = $this->municipalitieRepository->create($dataCreate);

            return $this->getMunicipalitieEntity($result->id);
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
    public function updateMunicipalitie(int $id, array $dataUpdate): array
    {
        $this->municipalitieRepository->findOneById($id);

        try {
            if (!empty($dataUpdate['file'])) {
                $putFile = Storage::putFile('public/category-spaces', $dataUpdate['file'], 'public');
                $dataUpdate['file'] = Storage::url($putFile);
            }

            if (isset($dataUpdate['name'])) {
                $checkName = $this->municipalitieRepository->handleCheckName($dataUpdate['name']);
                if (isset($checkName) && $checkName->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' =>  "The name has already been taken."
                    ];
                }
            }

            if (isset($dataUpdate['slug'])) {
                $checkSlug = $this->municipalitieRepository->handleCheckSlug($dataUpdate['slug']);
                if (isset($checkSlug) && $checkSlug->id != $id) {
                    return [
                        'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                        'msg' => "The slug has already been taken."
                    ];
                }
            }

            $this->municipalitieRepository->updateOneById($id, $dataUpdate);

            return $this->getMunicipalitieEntity($id);
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
    public function deleteMunicipalitie(int $id): array
    {
        $this->municipalitieRepository->findOneById($id);

        try {
            $this->municipalitieRepository->deleteOneById($id);

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
    public function getMunicipalitieEntity(int $id): array
    {
        $data = $this->municipalitieRepository->findOneById($id);

        return [
            'data' => $data->toArray(),
            'status' => Response::HTTP_OK
        ];
    }
}
