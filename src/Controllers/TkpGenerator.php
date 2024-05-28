<?php

namespace App\Controllers;

use App\Repository\ClientsRepository;
use App\Repository\ProductRepository;
use App\Repository\Tkp\TkpNastilRepository;
use App\Repository\Tkp\TkpOgradaRepository;
use App\Repository\Tkp\TkpPandusRepository;
use App\Repository\Tkp\TkpProductRepository;
use App\Repository\Tkp\TkpRepository;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;

class TkpGenerator
{
    private TkpRepository $tkpRepository;
    private ClientsRepository $clientsRepository;

    private ProductRepository $productRepository;
    private TkpProductRepository $tkpProductRepository;
    private TkpPandusRepository $tkpPandusRepository;
    private TkpOgradaRepository $tkpOgradaRepository;

    private TkpNastilRepository $tkpNastilRepository;

    public function __construct(
        TkpRepository  $tkpRepository,
        ClientsRepository $clientsRepository,
        ProductRepository $productRepository,
        TkpProductRepository $tkpProductRepository,
        TkpPandusRepository $tkpPandusRepository,
        TkpOgradaRepository $tkpOgradaRepository,
        TkpNastilRepository $tkpNastilRepository
    )
    {
        $this->tkpRepository = $tkpRepository;
        $this->clientsRepository = $clientsRepository;
        $this->productRepository = $productRepository;
        $this->tkpProductRepository = $tkpProductRepository;
        $this->tkpPandusRepository = $tkpPandusRepository;
        $this->tkpOgradaRepository = $tkpOgradaRepository;
        $this->tkpNastilRepository = $tkpNastilRepository;
    }
    public function createTkp($tkpId, $customerId, $installationPlace, $expiredDate) {
        $tkpInfo = $this->tkpRepository->filteredTkp(['id' => $tkpId]);
        if($tkpInfo) {
            $clientInfo = $this->clientsRepository->getRecordById($customerId);

            if($clientInfo) {
                error_reporting(E_ALL ^ E_WARNING);
                $customerName = $clientInfo['name'];
                $tkpData = $tkpInfo[0];
                $tkpPath = $tkpData['path'];
                $templatePrefix = __DIR__.'/../../uploads/tkp/';
                $tkpPath = $templatePrefix.$tkpPath;
                $dateCreate = date('d.m.Y');

                $templateProcessor = new TemplateProcessor($tkpPath);
                $templateProcessor->setValue('customerName', $customerName);
                $templateProcessor->setValue('instalationPlace', $installationPlace);
                $templateProcessor->setValue('expiredDate', $dateCreate);
                $templateProcessor->setValue('estimate_date', $expiredDate);

                $tkpProducts = $this->tkpProductRepository->getProducts($tkpId);
                $tkpNastil = $this->tkpNastilRepository->getProducts($tkpId);
                $tkpOgrada = $this->tkpOgradaRepository->getProducts($tkpId);
                $tkpPandus = $this->tkpPandusRepository->getProducts($tkpId);

                $tkpProductsArr = [];

                if($tkpProducts) {
                    foreach ($tkpProducts as $tkpProduct) {
                        $productData = $this->productRepository->getFilteredProducts(['id' => $tkpProduct['product_id']]);
                        $productPrice = $productData[0]['price'];
                        $productName = $productData[0]['name'];
                        $tkpProductsArr[] = [
                            'productName' => $productName,
                            'productPrice' => $productPrice
                        ];
                    }
                }

                if($tkpNastil) {
                    $productId = $tkpNastil[0]['product_id'];
                    $productData = $this->productRepository->getFilteredProducts(['id' => $productId]);
                    $templateProcessor->setValue('nastilPrice', $productData[0]['price']);
                }

                if($tkpOgrada) {
                    $productId = $tkpOgrada[0]['product_id'];
                    $productData = $this->productRepository->getFilteredProducts(['id' => $productId]);
                    $templateProcessor->setValue('ogradaPrice', $productData[0]['price']);
                }

                if($tkpPandus) {
                    $productId = $tkpOgrada[0]['product_id'];
                    $productData = $this->productRepository->getFilteredProducts(['id' => $productId]);
                    $templateProcessor->setValue('pandusPrice', $productData[0]['price']);
                }

                if($tkpProductsArr) {
                    $templateProcessor->cloneRowAndSetValues('productName', $tkpProductsArr);
                }

                $tkpName = explode('/', $tkpPath);
                $tkpName = array_pop($tkpName);

                $tkpTempName = date('dmYHis').'_'.$tkpName;
                $tkpTempPath = __DIR__.'/../../uploads/tkp_temp/';
                if(!file_exists($tkpPath)) {
                    mkdir($tkpPath);
                    chmod($tkpPath, 0777);
                }

                $outputFile = $tkpTempPath.$tkpTempName;
                $templateProcessor->saveAs($outputFile);
                return [
                    'filename' => $tkpTempName,
                    'filepath' => $tkpPath,
                    'output' => '/uploads/tkp_temp/'.$tkpTempName
                ];
            }

            return [
                'message' => 'somting went wrong',
                'err' => 'client id doesnt exist'
            ];

        }

        return [
            'message' => 'somting went wrong',
            'err' => 'tkp id doesnt exist'
        ];
    }
}