<?php

namespace common\components;

/**
 * Description of BuiltMasterNewCommands
 *
 * @author Prashant Swami <prashant.s@infinitylabs.in>
 */
class BuiltMasterNew extends \yii\base\Component {

    public static function getHostname($value = '') {
        return trim(str_replace("sysname", "", $value));
    }

    public static function getDnsServer($value = '') {
        return trim(str_replace("dns server", "", $value));
    }

    public static function getDnsServerSourceIp($value = '') {
        return trim(str_replace("dns server source-ip", "", $value));
    }

    public static function getReplacedValue($value = '', $replace) {
        return trim(str_replace("$replace", "", $value));
    }

    public function getPolicyCir($value) {
        $data = [];
        if (!empty($value)) {
            preg_match('/cir [0-9]+/', trim($value), $rem_host);
            if (!empty($rem_host)) {
                $data['cir'] = self::getReplacedValue($rem_host[0], 'cir');
            }
            preg_match('/pir [0-9]+/', trim($value), $rem_host);
            if (!empty($rem_host)) {
                $data['pir'] = self::getReplacedValue($rem_host[0], 'pir');
            }
            preg_match('/pbs [0-9]+/', trim($value), $rem_host);
            if (!empty($rem_host)) {
                $data['pbs'] = self::getReplacedValue($rem_host[0], 'pbs');
            }
            preg_match('/cbs [0-9]+/', trim($value), $rem_host);
            if (!empty($rem_host)) {
                $data['cbs'] = self::getReplacedValue($rem_host[0], 'cbs');
            }
        }
        return $data;
    }

    public function getLoopback($value) {
        $loopback = '';
        if (!empty($value)) {
            preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", trim($value), $temp);
            if (is_array($temp) && count($temp) > 0) {
                $loopback = trim($temp[0]);
            }
        }
        return $loopback;
    }

}
