<?php

namespace App\Repository;

use App\Models\NewsModel;

class NewsRepository
{
    private NewsModel $newsModel;
    public function __construct(NewsModel $newsModel) {
        $this->newsModel = $newsModel;
    }

    public function createNews(array $createArr): void {
        $this->newsModel::create($createArr);
    }

    public function update(array $updateArr,int $id): void {
        $this->newsModel::where('id', $id)->update($updateArr);
    }

    public function delete(int $id): void {
        $this->newsModel::where('id', $id)->delete();
    }

    public function getById(int $id): ?array {
        return $this->newsModel::where('id',$id)->first()->toArray();
    }

    public function getAllNews(): ?array {
        return $this->newsModel::orderBy('id', 'DESC')->get()->toArray();
    }

    public function getLastLimitNews(int $limit): ?array {
        return $this->newsModel::orderBy('id', 'DESC')->offset(0)->limit($limit)->get()->toArray();
    }
}