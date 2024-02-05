<?php


namespace App\Utils;


class CommonUtil
{
    public function genToken() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf(
            '%04X%04X-%04X-%04X-%04X-%04X%04X%04X',
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(16384, 20479),
            mt_rand(32768, 49151),
            mt_rand(0, 65535),
            mt_rand(0, 65535),
            mt_rand(0, 65535)
        );
    }

    public function convertDate(string $date, string $inputType, string $outputType): string {
        if($inputType == 'en') {
            if($outputType = 'ru'){
                $dateArr = explode('-', $date);
                return sprintf('%s.%s.%s', $dateArr['2'], $dateArr['1'], $dateArr['0']);
            }
        }

        if($inputType == 'ru') {
            if($outputType = 'en'){
                $dateArr = explode('.', $date);
                return sprintf('%s-%s-%s', $dateArr['2'], $dateArr['1'], $dateArr['0']);
            }
        }
    }
}