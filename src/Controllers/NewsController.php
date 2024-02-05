<?php

namespace App\Controllers;

use App\Repository\NewsRepository;
use App\Utils\CommonUtil;

class NewsController
{
    private NewsRepository $newsRepository;
    private CommonUtil $commonUtil;

    public function __construct(NewsRepository $newsRepository, CommonUtil $commonUtil) {
        $this->newsRepository = $newsRepository;
        $this->commonUtil = $commonUtil;
    }

    public function getNewsById(int $id): ?array {
        $result = $this->newsRepository->getById($id);
        if(!empty($result)) {
            $result['date_create'] = $this->commonUtil->convertDate($result['date_create'], 'en', 'ru');
        }

        return $result;
    }

    public function getLastNews(int $limit): ?array {
        $newsArr = [];
        $results = $this->newsRepository->getLastLimitNews($limit);
        if(!empty($results)) {
            foreach ($results as $result) {
                $result['date_create'] = $this->commonUtil->convertDate($result['date_create'], 'en', 'ru');
                $newsArr[] = $result;
            }
        }
        return $newsArr;
    }

    public function getAllNews(): ?array {
        $newsArr = [];
        $results = $this->newsRepository->getAllNews();
        if(!empty($results)) {
            foreach ($results as $result) {
                $result['date_create'] = $this->commonUtil->convertDate($result['date_create'], 'en', 'ru');
                $newsArr[] = $result;
            }
        }

        return $newsArr;
    }
}