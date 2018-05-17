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

    public static function getPolicyCir($value) {
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

    public static function getLoopback($value) {
        $loopback = '';
        if (!empty($value)) {
            preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", trim($value), $temp);
            if (is_array($temp) && count($temp) > 0) {
                $loopback = trim($temp[0]);
            }
        }
        return $loopback;
    }

    public static function getInterfaceData($rows, &$key) {
        $interface = [];
        $gigabitEthr = "";
        if (!empty($rows)) {
            while (trim($rows[$key]) != '' AND trim($rows[$key]) != '#') {
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
                if (preg_match("/^ospf cost/", trim($rows[$key])) AND ! empty($interface)) {
                    $interface['ospf_cost'] = trim(str_replace("ospf cost", "", $rows[$key]));
                }
                if (preg_match("/^ospf network-type/", trim($rows[$key])) AND ! empty($interface)) {
                    $interface['ospf_network_type'] = trim(str_replace("ospf network-type", "", $rows[$key]));
                }
                if (preg_match("/^ip address /", trim($rows[$key])) AND ! empty($interface)) {
                    $interface['ip_address'] = trim(str_replace("ip address", "", $rows[$key]));
                }
                if (preg_match("/^l2 binding vsi /", trim($rows[$key])) AND ! empty($interface)) {
                    $interface['l2_binding_vsi'] = trim(str_replace("l2 binding vsi", "", $rows[$key]));
                }
                if (preg_match("/^undo shutdown/", trim($rows[$key])) AND ! empty($interface)) {
                    $interface['shutdown_status'] = "no shutdown";
                }
                if (preg_match("/^shutdown/", trim($rows[$key])) AND ! empty($interface)) {
                    $interface['shutdown_status'] = "shutdown";
                }
                if (preg_match("/^ospf timer hello/", trim($rows[$key]), $match) AND ! empty($interface)) {
                    preg_match("|\d+|", trim($match[0]), $tmp);
                    if (isset($tmp[0]) && !empty($tmp[0])) {
                        $interface['ospf_time_hello'] = $tmp[0];
                    }
                }
                if (preg_match("/^ospf timer dead/", trim($rows[$key]), $match) AND ! empty($interface)) {
                    preg_match("|\d+|", trim($match[0]), $tmp);
                    if (isset($tmp[0]) && !empty($tmp[0])) {
                        $interface['ospf_time_dead'] = $tmp[0];
                    }
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
                if (preg_match("/^eth-trunk/", trim($rows[$key]), $tmp) AND ! empty($interface)) {
                    preg_match("|\d+|", trim($rows[$key]), $tmp);
                    if (!empty($tmp)) {
                        $interface['eth_trunk'] = trim($tmp[0]);
                    }
                }


                $key++;
            }
        }
        return $interface;
    }

    public static function getIp($val) {
        if (preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $val, $temp)) {
            if (!empty($temp)) {
                return $temp[0];
            }
        }
        return "";
    }

    public static function getBdiData($rows, &$key) {
        $data = [];
        if (!empty($rows)) {
            while (trim($rows[$key]) != '' AND trim($rows[$key]) != '#') {
                if (preg_match("/^interface Eth-Trunk/", $rows[$key])) {
                    $explode = explode(".", $rows[$key]);
                    if (!empty($explode)) {
                        preg_match("|\d+|", trim($explode[0]), $temp);
                        if (!empty($temp)) {
                            $data['eth_trunk'] = $temp[0] + 1;
                        }
                        if (!empty($explode[1])) {
                            $data['bdi'] = $data['eth_trunk'] . substr($explode[1], 0, 1);
                        }
                    }
                }
                if (preg_match("/^description/", trim($rows[$key])) AND ! empty($data)) {
                    $data['description'] = trim(str_replace("description", "", $rows[$key]));
                }
                if (preg_match("/^ospf cost/", trim($rows[$key])) AND ! empty($data)) {
                    $data['ospf_cost'] = trim(str_replace("ospf cost", "", $rows[$key]));
                }
                if (preg_match("/^ospf network-type/", trim($rows[$key])) AND ! empty($data)) {
                    $data['ospf_network_type'] = trim(str_replace("ospf network-type", "", $rows[$key]));
                }
                if (preg_match("/^ip address /", trim($rows[$key])) AND ! empty($data)) {
                    $data['ip_address'] = trim(str_replace("ip address", "", $rows[$key]));
                }
                if (preg_match("/^control-vid/", trim($rows[$key])) AND ! empty($data)) {
                    preg_match("|\d+|", trim($rows[$key]), $temp);
                    if (!empty($temp)) {
                        $data['dot1q_termination_vid'] = $temp[0];
                    }
                }
                $key++;
            }
        }
        return $data;
    }

    public static function getVsiData($rows, &$key) {
        $data = [];
        if (!empty($rows)) {
            while (trim($rows[$key]) != '' AND trim($rows[$key]) != '#') {
                if (preg_match("/^vsi/", $rows[$key])) {
                    $explode = explode(" ", $rows[$key]);
                    if (!empty($explode)) {
                        $data['vsi_name'] = $explode[1];
                    }
                }
                if (preg_match("/^description/", trim($rows[$key])) AND ! empty($data)) {
                    $data['description'] = trim(str_replace("description", "", $rows[$key]));
                }
                if (preg_match("/^vsi-id/", trim($rows[$key])) AND ! empty($data)) {
                    preg_match("|\d+|", trim($rows[$key]), $temp);
                    if (!empty($temp))
                        $data['vsi_id'] = trim($temp[0]);
                }
                if (preg_match("/^peer/", trim($rows[$key])) AND ! empty($data)) {
                    if (preg_match("/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/", trim($rows[$key]), $temp)) {
                        if (!empty($temp)) {
                            if (empty($data['peer']))
                                $data['peer'] = $temp[0];
                            else
                                $data['peer'] .= "," . $temp[0];
                        }
                    }
                }
                $key++;
            }
        }
        return $data;
    }

}
