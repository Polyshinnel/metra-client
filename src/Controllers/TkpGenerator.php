<?php

namespace App\Controllers;

use App\Repository\ClientsRepository;
use App\Repository\Tkp\TkpRepository;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\TemplateProcessor;

class TkpGenerator
{
    private TkpRepository $tkpRepository;
    private ClientsRepository $clientsRepository;

    public function __construct(TkpRepository  $tkpRepository, ClientsRepository $clientsRepository) {
        $this->tkpRepository = $tkpRepository;
        $this->clientsRepository = $clientsRepository;
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