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

    public function getInterfaceData($rows, &$key) {
        $interface = [];
        $gigabitEthr = "";
        if (!empty($rows)) {
            while ($rows[$key] != '' AND $rows[$key] != '#') {

                if (preg_match("/interface GigabitEthernet/", $rows[$key]) OR preg_match("/interface TenGigabitEthernet/", $rows[$key])) {
                    $phyGigInt = explode(' ', $rows[$key]);
                    $gigabit = explode(".", $phyGigInt[1]);
                    $gigabitEthr = $gigabit[0];
                    $interface['interface'] = $gigabitEthr;
                    if (isset($gigabit[1]) AND ! empty($gigabit[1])) {
                        $interface['bdi'] = $gigabit[1];
                    }
                }

                if (preg_match("/^description/", trim($rows[$key])) AND ! empty($interface)) {
                    $interface['description'] = trim(str_replace("description", "", $rows[$key]));
                }
                if (preg_match("/^control-vid \d{1,}/", trim($rows[$key]), $match) AND ! empty($interface)) {
                    preg_match("|\d+|", trim($match[0]), $tmp);
                    if (!empty($tmp) AND isset($tmp[0]))
                        $interface['dot1q_termination'] = trim($tmp[0]);
                }
                if (preg_match("/^qinq termination /", trim($rows[$key]), $match) AND ! empty($interface)) {
                    $interface['dot1q_termination'] = "";
                    preg_match("/ce-vid \d+/", trim($rows[$key]), $tmp);
                    if (!empty($tmp) AND isset($tmp[0])) {
                        preg_match("|\d+|", trim($tmp[0]), $cevid);
                        if (!empty($cevid[0]) AND isset($cevid[0])) {
                            $interface['dot1q_termination'] .= trim($cevid[0]);
                        }
                    }


                    preg_match("/pe-vid \d+/", trim($rows[$key]), $tmp1);
                    if (!empty($tmp1) AND isset($tmp1[0])) {
                        preg_match("|\d+|", trim($tmp1[0]), $pevid);
                        if (!empty($cevid[0]) AND isset($pevid[0])) {
                            $interface['dot1q_termination'] .= "," . trim($pevid[0]);
                        }
                    }
                }


                $key++;
            }
        }
        return $interface;
    }

}
