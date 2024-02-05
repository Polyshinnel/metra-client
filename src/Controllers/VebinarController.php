<?php

namespace App\Controllers;

use App\Repository\VebinarRepository;
use App\Utils\CommonUtil;

class VebinarController
{
    private VebinarRepository $vebinarRepository;
    private CommonUtil $commonUtil;

    public function __construct(VebinarRepository $vebinarRepository, CommonUtil $commonUtil)
    {
        $this->vebinarRepository = $vebinarRepository;
        $this->commonUtil = $commonUtil;
    }

    public function getAllVebinars(): ?array {
        $vebinars = [];
        $results = $this->vebinarRepository->getAllVebinars();
        if(!empty($results)) {
            foreach ($results as $result) {
                $result['date_create'] = $this->commonUtil->convertDate($result['date_create'], 'en', 'ru');
                $vebinars[] = $result;
            }
        }

        return $vebinars;
    }

    public function getLimitedVebinars(int $limit): ?array {
        $vebinars = [];
        $results = $this->vebinarRepository->getLimitVebinars($limit);
        if(!empty($results)) {
            foreach ($results as $result) {
                $result['date_create'] = $this->commonUtil->convertDate($result['date_create'], 'en', 'ru');
                $vebinars[] = $result;
            }
        }

        return $vebinars;
    }

    public function getVebinarById(int $id): ?array {
        $result = $this->vebinarRepository->getVebinarById($id);
        if(!empty($result)) {
            $result['date_create'] = $this->commonUtil->convertDate($result['date_create'], 'en', 'ru');
        }
        return $result;
    }
}