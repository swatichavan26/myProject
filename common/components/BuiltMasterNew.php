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

}
