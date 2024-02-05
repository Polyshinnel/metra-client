<?php

namespace App\Controllers;

use App\Repository\BannerRepository;

class BannerController
{
    private BannerRepository $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function getAllBanners(): ?array {
        return $this->bannerRepository->getAllBanners();
    }
}