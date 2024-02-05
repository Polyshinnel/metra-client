<?php

namespace App\Repository;

use App\Models\BannerModel;

class BannerRepository
{
    private BannerModel $bannerModel;

    public function __construct(BannerModel $bannerModel) {
        $this->bannerModel = $bannerModel;
    }

    public function createBanner(array $createArr): void {
        $this->bannerModel::create($createArr);
    }

    public function updateBanner(int $id, array $updateArr): void {
        $this->bannerModel::where('id', $id)->update($updateArr);
    }

    public function deleteBanner(int $id): void {
        $this->bannerModel::where('id', $id)->delete();
    }

    public function getAllBanners(): ?array {
        return $this->bannerModel::all()->toArray();
    }

    public function getBannerById(int $id): ?array {
        return $this->bannerModel::where('id', $id)->first()->toArray();
    }
}